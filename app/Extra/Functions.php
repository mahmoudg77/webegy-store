<?php

namespace App\Extra;
use Illuminate\Http\Request;
use Form;
use Carbon\Carbon;
//use Illuminate\Support\Facades\Cache;
class Functions
{
    public static function Success($message = '', array $sentData = [], $redirect = "") {
        $response['type'] = 'success';
        $response['message'] = $message;
        $response['data'] = $sentData;
        //$sentData['response']=$response;

        //dd($sentData);
        if (\Request::ajax()) {
            return json_encode($response);
        } else {
            session()->put('response', $response);
            if ($redirect == "")
                return redirect()->back();
            else return redirect($redirect);
            //          if($view!="") return view($view,$sentData);
            //         return "<div class='alert alert-success'>".$message."</div>";
        }
    }
    public static function Error($message = '', $view = "", array $sentData = []) {
        $response['type'] = 'error';
        $response['message'] = $message;
        $response['data'] = $sentData;


        //dd($sentData);
        if (\Request::ajax()) {

            return json_encode($response);
        } else {
            session()->put('response', $response);
            if ($view != "") return view($view, $sentData);
            return redirect()->back(); //"<div class='alert alert-danger'>".$message."</div>";
        }
    }

    public static function actionLinks($routeBase, $id, $elm_parent = "tr", array $attrs = []) {
        $class_del = "btn btn-danger btn-sm ";
        $class_edit = "btn btn-success btn-sm ";
        $class_view = "btn btn-info btn-sm ";

        if (in_array('delete', array_keys($attrs)) && in_array('class', array_keys($attrs['delete']))) {
            $class_del .= $attrs['delete']['class'];
        }
        if (in_array('edit', array_keys($attrs)) && in_array('class', array_keys($attrs['edit']))) {
            $class_edit .= $attrs['edit']['class'];
        }
        if (in_array('view', array_keys($attrs)) && in_array('class', array_keys($attrs['view']))) {
            $class_view .= $attrs['view']['class'];
        }
        $sitebarmenu = \request()->get('curr_menu');

        $returned = Form::open(['route' => ["cp.$routeBase.destroy", $id], "method" => "DELETE", "class" => "ajax-delete", "elm-parent" => $elm_parent, 'onsubmit' => "return confirm('Are you sure you want to delete this item?');"])."\n\r";
        $returned .= '<button class="'.$class_del.'" type="submit" ><i class="fa fa-trash"></i> '."</button>\n\r";
        $returned .= '<a href="'.(in_array('edit', array_keys($attrs)) && in_array('href', array_keys($attrs['edit']))?$attrs['edit']['href']:route("cp.$routeBase.edit", ['post' => $id, 'curr_menu' => $sitebarmenu])).'" class="'.$class_edit.'"><i class="fa fa-edit"></i> '.'</a>'."\n\r";
        $returned .= '<a href="'.(in_array('view', array_keys($attrs)) && in_array('href', array_keys($attrs['view']))?$attrs['view']['href']:route("cp.$routeBase.show", ['post' => $id, 'curr_menu' => $sitebarmenu])).'" class="'.$class_view.'"><i class="fa fa-eye"></i> '.'</a>'."\n\r";
        $returned .= Form::close()."\n\r";
        return $returned;
    }
    public static function langslug($url, $langcode = null, $attributes = array(), $https = null) {
        $url = URL::to($url, $https);

        if (is_null($langcode)) $langcode = $url;

        return '<a href="'.$url.'"'.static::attributes($attributes).'>'.static::entities($langcode).'</a>';
    }

    public static function controllers() {

        $list = [];
        foreach (glob(dirname(__FILE__)."/../Http/Controllers/*.php") as $filename) {
            $name = explode('/', $filename);
            $name = $name[count($name)-1];
            include_once $filename;
        }
        foreach (glob(dirname(__FILE__)."/../Http/Controllers/Dashboard/*.php") as $filename) {
            $name = explode('/', $filename);
            $name = $name[count($name)-1];
            include_once $filename;
        }


        foreach (get_declared_classes() as $class) {
            if (strpos($class, 'App\Http\Controllers\\', 0) !== false) {
                $obj = new $class;
                $list[$class] = property_exists($class, 'metaTitle') && $obj->metaTitle != null ?$obj->metaTitle:str_replace('App\Http\Controllers\\', '', $class); //$obj->metaTitle;
            }
        }
        asort($list);
        return $list;
    }

    public static function applyForceFilter($class, $force_filter) {
        //$c=new $class;
        if (!$class) return null;
        $data = $class::query();//orderBy('id', 'desc');
        // $force_filter=request()->get('force_filter');
        // dd($force_filter);
        if ($force_filter) {
            foreach ($force_filter as $key => $value) {
                if ($value[1] == 'in')
                    $data = $data->whereIn($value[0], $value[2]);
                else
                    $data = $data->where($value[0], $value[1], $value[2]);
            }
        }
        return $data;
    }
    public static function checkValue($left, $strOperator, $right) {

        switch ($strOperator) {
            case "=":
                return $left == $right;
                break;

            case ">";
                return $left > $right;
                break;

            case "<";
                return $left < $right;
                break;
            case ">=";
                return $left >= $right;
                break;
            case "<=";
                return $left <= $right;
                break;
            case "<>";
                return $left != $right;
                break;
            case "like";
                return strpnbbos($left, $right);
                break;
            case "in";
                return in_array($left, $right);
                break;
        }
    }
    public static function menu($location) {
        /* $menu=cache()->remember('sitemenu_'.$location,Carbon::now()->addMinutes(30),function()use($location){
             return \App\Models\Menu::with('Links',function ($query) {
                 $query->where('parent_id', '=', 0)
                     ->orWhereNull('parent_id');
             })->where("location",$location)->get();
         });*/
        //dd('test');
        return cache()->remember('site_menu_'.$location, Carbon::now()->addMinutes(30), function()use($location) {
            $menu = \App\Models\Menu::with('Links')
            //->whereHas('Links',function ($query) {
            //$query->where(function($q){
            // $q->where('parent_id', '=', 0)
            //    ->orWhereNull('parent_id');
            // });

            //})
            ->where("location", $location)->first();
            if (!$menu)
                $menu = [];
            return $menu->Links()->where(function($q) {
                $q->where('parent_id', '=', 0)
                ->orWhereNull('parent_id');
            })->get();
    });
    //dd($menu);
    //$menu= \App\Models\Menu::where("location",$location)->first();
    /*if($menu){
             $menu= $menu->Links()->where(function ($query) {
                 $query->where('parent_id', '=', 0)
                     ->orWhereNull('parent_id');
             })->get();
         }*/


}
public static function menuLink($menuLink) {
    if (empty($menuLink->customlink)) {

        if ($menuLink->category_id > 0) {
            if ($menuLink->hassubs) {
                return '#';
            } else {
                return route('getPostsByCatID', ['id' => $menuLink->category_id]);
            }
        } else {
            return route('home');
        }

    } else {
        if (Functions::link_is_external($menuLink->customlink)) {
            return $menuLink->customlink;
        } else {

            return '/'.app()->getLocale().$menuLink->customlink;
        }
    }
}
public static function link_is_external($link) {
    return substr($link, 0, 4) == 'http' || substr($link, 0, 2) == '//';
}

public static function getCategoriesList($root = null) {
    $cats = [];
    if ($root == null) {
        $list = \App\Models\Category::all();

        $newcat = new \App\Models\Category();
        $newcat->id = null;
        $newcat->title = "Main Categories";
        $newcat->Chields = \App\Models\Category::whereNull('parent_id')->get();

        for ($x = count($newcat->Chields)-1; $x >= 0; $x--) {
            if (count($newcat->Chields[$x]->Chields) > 0) {
                unset($newcat->Chields[$x]);
            }
        }
        $list[] = $newcat;

    } else {
        $list = \App\Models\Category::where('id', $root)->get();
    }
    foreach ($list as $cat) {
        foreach ($cat->Chields as $chield) {
            $cats[$cat->title][$chield->id] = $chield->title;
        }
    }

    return $cats;
}

public static function getPageBySlug($slug) {
    return \App\Models\Post::where('slug', $slug)->first();
}

private function my_slug($class, $string, $separator = '-') {
    $string = trim($string);
    $string = mb_strtolower($string, 'UTF-8');

    // Remove multiple dashes or whitespaces or underscores
    $string = preg_replace("/[\s-_]+/", ' ', $string);
    // Convert whitespaces and underscore to the given separator
    $string = preg_replace("/[\s_]/", $separator, $string);

    $slug = rawurldecode($string);

    $n = 1;
    while ($class::where('slug', $slug)->count() > 0) {
        $slug = $c_slug."_".$n;
        $n++;
    }

    return $slug;
    //return rawurldecode($string);
}

function make_slug($string = null, $separator = "-") {
    if (is_null($string)) {
        return "";
    }

    // Remove spaces from the beginning and from the end of the string
    $string = trim($string);

    // Lower case everything
    // using mb_strtolower() function is important for non-Latin UTF-8 string | more info: http://goo.gl/QL2tzK
    $string = mb_strtolower($string, "UTF-8");;

    // Make alphanumeric (removes all other characters)
    // this makes the string safe especially when used as a part of a URL
    // this keeps latin characters and arabic charactrs as well
    $string = preg_replace("/[^a-z0-9_\s-ءاأإآؤئبتثجحخدذرزسشصضطظعغفقكلمنهويةى]/u", "", $string);

    // Remove multiple dashes or whitespaces
    $string = preg_replace("/[\s-]+/", " ", $string);

    // Convert whitespaces and underscore to the given separator
    $string = preg_replace("/[\s_]/", $separator, $string);

    return $string;
}

public static function getFreeSlug($class, $title) {
    //$title=\request()->get('title');
    $c_slug = str_slug($title, '-');
    $slug = $c_slug;
    $n = 1;
    while ($class::where('slug', $slug)->count() > 0) {
        $slug = $c_slug."_".$n;
        $n++;
    }

    return $slug;
}

public static function tagLinks($strTags) {
    if (empty($strTags)) return "";
    $list = explode(",", $strTags);
    $result = [];
    foreach ($list as $tag) {
        $result[] = "<li><a href='".route('getPostsByTag', ['tag' => $tag])."' class='text-capitalize'>".$tag."</a></li>";
    }
    return implode(" ", $result);
}


public static function drowMenuLink($link, $class = ['li' => 'dropdown submenu nav-item']) {
    if (!in_array('a', array_keys($class)))$class['a'] = '';
    if (!in_array('li', array_keys($class)))$class['li'] = '';


    $result = '<li class=" '.$class['li'] . ' ' .(request()->is($link->category_id > 0?ltrim(route('categoryBySlug', $link->Category->slug, false), "/"):app()->getLocale().$link->customlink)?'active':'').'">';

    if ($link->Links()->count() > 0) {
        $result .= '<a href="#" class="dropdown-toggle '.$class['a'].'" data-toggle="dropdown" role="button"
                                       aria-haspopup="true" aria-expanded="false">
                                        '.$link->title.' <span class="caret"></span></a>
                                    <ul class="dropdown-menu">';
        foreach ($link->Links as $sublink) {
            $result .= self::drowMenuLink($sublink);
        }
        $result .= ' </ul>';
    } else {
        if ($link->category_id > 0) {
            if ($link->hasSubs) {
                $cat = \App\Models\Category::find($link->category_id);
                $result .= self::drowMenuCat($cat);
            } else {
                $result .= '<a class="'.$class['a'].'" href="' . route('categoryBySlug', $link->Category->slug) . '" >' . $link->title . '</a>';
            }
        } else {
            $result .= ' <a class="'.$class['a'].'" href="' . self::menuLink($link) . '" >' .($link->display_icon?'<i class="fa '.$link->icon.'" aria-hidden="true"></i> ':'') . ($link->display_title?$link->title:'') . '</a>';
        }
    }
    $result .= ' </li>';
    return $result;
}
public static function drowMenuCat($cat) {
    $result = '<li class="'.(request()->is(ltrim(route('categoryBySlug', $cat->slug, false), "/")?'active':'')).'">';

    $result = "";

    //$cat = \App\Models\Category::find($link->category_id);

    if (count($cat->Chields) > 0) {
        $result .= '<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button"
                           aria-haspopup="true" aria-expanded="false">
                            ' . $cat->title . ' <span class="caret"></span></a>
                        <ul class="dropdown-menu">';
        foreach ($cat->Chields as $chield) {
            $result .= '
                               <li class="' . (request()->is(ltrim(route('categoryBySlug', $chield->slug, false), ' / ')) ? 'active' : '') . '">
                                <a href="' . route('categoryBySlug', $chield->slug) . '" class="">' . $chield->title . '</a></li>';
        }
        $result .= '</ul>';
    } else {
        $result .= '<a href="' . route('categoryBySlug', $cat->slug) . '" >' . $cat->title . '</a>';
    }

    // $result .= ' </li>';
    return $result;
}

public static function drowMenuLink2($link, $class = ['li' => 'nav-item dropdown']) {
    if (!in_array('a', array_keys($class)))$class['a'] = 'nav-link';
    if (!in_array('li', array_keys($class)))$class['li'] = '';


    $result = '<li class=" '.$class['li'] . ' ' .(request()->is($link->category_id > 0?ltrim(route('categoryBySlug', $link->category->slug, false), "/"):app()->getLocale().$link->customlink)?'active':'').'">';

    if ($link->Links()->count() > 0) {
        $result .= '<a href="#" class="nav-link '.$class['a'].'">'.$link->title.'<span class="caret"></span></a>
                        <ul class="dropdown-menu">';
        foreach ($link->Links as $sublink) {
            $result .= self::drowMenuLink($sublink);
        }
        $result .= ' </ul>';
    } else {
        if ($link->category_id > 0) {
            if ($link->hasSubs) {
                $cat = \App\Models\Category::find($link->category_id);
                $result .= self::drowMenuCat($cat);
            } else {
                $result .= '<a class="'.$class['a'].'" href="' . route('categoryBySlug', $link->category->slug) . '" >' . $link->title . '</a>';
            }
        } else {
            $result .= ' <a class="'.$class['a'].'" href="' . self::menuLink($link) . '" >' .($link->display_icon?'<i class="fa '.$link->icon.'" aria-hidden="true"></i> ':'') . ($link->display_title?$link->title:'') . '</a>';
        }
    }
    $result .= ' </li>';
    return $result;
}

public static function drowMenuCat2($cat) {
    $result = '<li class="'.(request()->is(ltrim(route('categoryBySlug', $cat->slug, false), "")?'active':'')).'">';
    $result = "";
    //$cat = \App\Models\Category::find($link->category_id);
    if (count($cat->Chields) > 0) {
        $result .= '<a href="#" class="nav-link dropdown-toggle">'. $cat->title . '<span class="caret"></span> </a>
                            <ul class="dropdown-menu">';
        foreach ($cat->Chields as $chield) {
            $result .= '
                        <li class="nav-item dropdown ' . (request()->is(ltrim(route('categoryBySlug', $chield->slug, false), '/')) ? 'active' : '') . '">
                        <a href="' . route('categoryBySlug', $chield->slug) . '" class="dropdown-toggle dropdown-item">' . $chield->title . '</a></li>';
        }
        $result .= '</ul>';
    } else {
        $result .= '<a href="' . route('categoryBySlug', $cat->slug) . '" >' . $cat->title . '</a>';
    }
    // $result .= ' </li>';
    return $result;
}
public static function time_string($time, $format = "Y-m-d h:i A") {
    $ptime = strtotime($time);
    $etime = time() - $ptime; //$this->pub_date ;


    if ($etime >= 86400*2 || $etime < 0) {
        return date($format, $ptime);
        $d = date("d", $ptime);
        $m = date("m", $ptime);
        $y = date("Y", $ptime);
        $t = date("h:i", $ptime);
        $A = date("A", $ptime);

        return $d.' '.
        trans('time.Months.'.($m-1)).' '.
        $y.' '.
        $t.' '.
        trans("time.$A"); // date("d-M-y h:i A",$ptime);
    }
    if ($etime <= 20) {

        return trans('time.now');

    }

    $a = trans('time.times_value');
    $a_plural = trans('time.times_name');


    //if(!is_array($a)) return $etime;
    foreach ($a as $secs => $str) {
        $d = $etime / $secs;
        //dd($d);
        if ($d >= 1) {
            $r = round($d);
            if (app()->getLocale() == "ar") {
                return trans('time.ago') . ' ' . ($r < 3?'':$r . ' '). ($r > 1 ? trans("time.times_name".($r == 2?'_twins':'').'.'.$str) : $str);
            } else {
                return $r . ' ' . ($r > 1 ? trans("time.times_name.$str") : $str) . ' '.trans('time.ago');
            }
        }

    }


}
}