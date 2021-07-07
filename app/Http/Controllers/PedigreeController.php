<?php

namespace App\Http\Controllers;

use App\Jobs\ExportGedCom;
use App\Models\Family;
use App\Models\Note;
use App\Models\Person;
use App\Models\User;
use File;
// use LaravelEnso\Avatars\Models\Avatar;
// use LaravelEnso\Files\Models\File as UploadFile;

// use App\Traits\ConnectionTrait;
use FamilyTree365\LaravelGedcom\Utils\GedcomGenerator;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use LaravelEnso\Core\Models\User as CoreUser;
use Response;

class PedigreeController extends Controller
{
    private $persons;
    private $unions;
    private $links;
    private $all;
    private $nest;
    private $family_id;
    private $person_id;
    private $child_id;

    public function show(Request $request)
    {
        //dd("Here");
        $start_id = $request->get('start_id');
        $nest = $request->get('nest', 2);
        $ret = [];
        $ret['start'] = (int) $start_id;
        $this->persons = [];
        $this->unions = [];
        $this->links = [];
        $this->nest = $nest;
        $this->family_id = [];
        $this->person_id = [];
        $this->start_id = [];
        $this->child_id = [];
        $this->checklink = [];
        // $this->getGraphData((int)$start_id);
        $this->getGraphDataUpward((int) $start_id);
        $ret['checklink'] = $this->checklink;
        $ret['persons'] = $this->persons;
        $ret['unions'] = $this->unions;
        $ret['links'] = $this->links;
        $ret['all'] = $this->all;
        $ret['family_id'] = $this->family_id;
        $ret['person_id'] = $this->person_id;
        $ret['start_id'] = $this->start_id;
        $ret['child_id'] = $this->child_id;
        // ExportGedCom::dispatch(2, $request);
        // $file = 'file.GED';
        // $destinationPath = public_path().'/upload/';
        // $ret['link'] = $destinationPath.$file;

        return $ret;
    }

    private function getGraphDataUpward($start_id, $nest = 0)
    {

        // $conn = $this->getConnection();
        // $db = $this->getDB();
        if ($this->nest >= $nest) {
            $person = Person::find($start_id);

            if ($person) {
                $user = $person->user;
                if ($user) {
                    $av = Avatar::where('user_id', '=', $user->id)->first();
                    $file = UploadFile::where('attachable_id', '=', $av->id)->where('attachable_type', '=', 'avatar')->first();

                    if ($file) {
                        $person->setAttribute('avatar', '/api/core/avatars/'.$av->id);
                    } else {
                        $person->setAttribute('avatar', '');
                    }
                }
            }

            // do not process for null
            if ($person == null) {
                return;
            }

            // do not process again
            if (array_key_exists($start_id, $this->persons)) {
                return;
            }
            // do self
            if (! array_key_exists($start_id, $this->persons)) {
                // this is not added
                $_families = Family::where('husband_id', $start_id)->orwhere('wife_id', $start_id)->select('id')->get();
                $_union_ids = [];
                foreach ($_families as $item) {
                    $_union_ids[] = 'u'.$item->id;
                    // add current family link
                    // $this->links[] = [$start_id, 'u'.$item->id];
                    array_unshift($this->links, [$start_id, 'u'.$item->id]);
                }
                $person->setAttribute('own_unions', $_union_ids);
                $person->setAttribute('parent_union', 'u'.$person->child_in_family_id);
                // add to persons
                $this->persons[$start_id] = $person;

                // get self's parents data
                if ($person) {
                    if ($person->id == 680) {
                        array_unshift($this->person_id, 'first'.$person->id);
                    }
                }
                $p_family_id = $person->child_in_family_id;
                array_unshift($this->start_id, 'family_in_child_id'.$person->child_in_family_id);
                if ($p_family_id) {
                    array_unshift($this->family_id, 'first'.$p_family_id);
                }
                if (! empty($p_family_id)) {
                    // add parent family link
                    // $this->links[] = ['u'.$p_family_id,  $start_id] ;
                    array_unshift($this->links, ['u'.$p_family_id,  $start_id]);
                    $p_family = Family::find($p_family_id);
                    if (isset($p_family->husband_id)) {
                        $p_fatherid = $p_family->husband_id;
                        $this->getGraphDataUpward($p_fatherid, $nest + 1);
                    }
                    if (isset($p_family->wife_id)) {
                        $p_motherid = $p_family->wife_id;
                        $this->getGraphDataUpward($p_motherid, $nest + 1);
                    }
                }
            }
            // get partner
            $cu_families = Family::where('husband_id', $start_id)->orwhere('wife_id', $start_id)->get();
            foreach ($cu_families as $family) {
                $family_id = $family->id;
                $father = Person::find($family->husband_id);
                $mother = Person::find($family->wife_id);

                $user = null; //$father->user;

                if ($user) {
                    $av = Avatar::where('user_id', '=', $user->id)->first();
                    $file = UploadFile::where('attachable_id', '=', $av->id)->where('attachable_type', '=', 'avatar')->first();

                    if ($file) {
                        $father->setAttribute('avatar', '/api/core/avatars/'.$av->id);
                    } else {
                        $father->setAttribute('avatar', '');
                    }
                    $father->setAttribute('relation', 'father');
                }

                if ($mother) {
                    $user = $mother->user;

                    if ($user) {
                        $av = Avatar::where('user_id', '=', $user->id)->first();
                        $file = UploadFile::where('attachable_id', '=', $av->id)->where('attachable_type', '=', 'avatar')->first();

                        if ($file) {
                            $mother->setAttribute('avatar', '/api/core/avatars/'.$av->id);
                        } else {
                            $mother->setAttribute('avatar', '');
                        }
                        $mother->setAttribute('relation', 'mother');
                    }
                }

                if (isset($father->id)) {
                    if (! array_key_exists($father->id, $this->persons)) {
                        // this is not added
                        $_families = Family::where('husband_id', $father->id)->orwhere('wife_id', $father->id)->select('id')->get();
                        $_union_ids = [];
                        foreach ($_families as $item) {
                            $_union_ids[] = 'u'.$item->id;
                        }
                        $father->setAttribute('own_unions', $_union_ids);
                        $father->setAttribute('parent_union', 'u'.$father->child_in_family_id);
                        // add to persons
                        $this->persons[$father->id] = $father;

                        // add current family link
                        // $this->links[] = [$father->id, 'u'.$family_id];
                        array_unshift($this->links, [$father->id, 'u'.$family_id]);
                        // get husband's parents data
                        $p_family_id = $father->child_in_family_id;
                        if ($p_family_id) {
                            array_unshift($this->family_id, 'father'.$p_family_id);
                        }
                        if (! empty($p_family_id)) {
                            // add parent family link
                            // $this->links[] = ['u'.$p_family_id,  $father->id] ;
                            array_unshift($this->links, ['u'.$p_family_id,  $father->id]);
                            $p_family = Family::find($p_family_id);
                            if (isset($p_family->husband_id)) {
                                $p_fatherid = $p_family->husband_id;
                                $this->getGraphDataUpward($p_fatherid, $nest + 1);
                            }
                            if (isset($p_family->wife_id)) {
                                $p_motherid = $p_family->wife_id;
                                $this->getGraphDataUpward($p_motherid, $nest + 1);
                            }
                        }
                    }
                }
                if (isset($mother->id)) {
                    if (! array_key_exists($mother->id, $this->persons)) {
                        // this is not added
                        $_families = Family::where('husband_id', $mother->id)->orwhere('wife_id', $mother->id)->select('id')->get();
                        $_union_ids = [];
                        foreach ($_families as $item) {
                            $_union_ids[] = $item->id;
                        }
                        $mother->setAttribute('own_unions', $_union_ids);
                        $mother->setAttribute('parent_union', 'u'.$mother->child_in_family_id);
                        // add to person
                        $this->persons[$mother->id] = $mother;
                        // add current family link
                        // $this->links[] = [$mother->id, 'u'.$family_id];
                        array_unshift($this->links, [$mother->id, 'u'.$family_id]);
                        // get wifee's parents data
                        $p_family_id = $mother->child_in_family_id;
                        if ($p_family_id) {
                        }
                        if (! empty($p_family_id)) {
                            // add parent family link
                            // $this->links[] = ['u'.$p_family_id,  $father->id] ;
                            array_unshift($this->links, ['u'.$p_family_id,  $mother->id]);

                            $p_family = Family::find($p_family_id);
                            if (isset($p_family->husband_id)) {
                                array_unshift($this->family_id, 'mother'.$p_family_id);
                                $p_fatherid = $p_family->husband_id;
                                $this->getGraphDataUpward($p_fatherid, $nest + 1);
                            }
                            if (isset($p_family->wife_id)) {
                                array_unshift($this->family_id, 'mother'.$p_family_id);
                                $p_motherid = $p_family->wife_id;
                                $this->getGraphDataUpward($p_motherid, $nest + 1);
                            }
                        }
                    }
                }

                // find children
                $children = Person::where('child_in_family_id', $family_id)->get();
                $children_ids = [];
                foreach ($children as $child) {
                    $this->getGraphDataUpward($child->id, $nest + 1);
                    if ($child->id == 680) {
                        array_unshift($this->family_id, $child->id);
                    }
                    $child_id = $child->id;
                    $children_ids[] = $child_id;
                }

                // compose union item and add to unions
                $union = [];
                $union['id'] = 'u'.$family_id;
                $union['partner'] = [isset($father->id) ? $father->id : null, isset($mother->id) ? $mother->id : null];
                $union['children'] = $children_ids;
                $this->unions['u'.$family_id] = $union;
            }
            //get brother/sisters
            $i = 0;
            $brothers = Person::where('child_in_family_id', $person->child_in_family_id)
                ->whereNotNull('child_in_family_id')
                ->where('id', '<>', $start_id)->get();

            foreach ($brothers as $brother) {
                // if($i < 2) {
                $this->getGraphDataUpward($brother->id, $nest + 1);
                // }
                $i++;
            }
        } else {
            return;
        }
    }
}
