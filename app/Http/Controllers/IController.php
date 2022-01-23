<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
// use Illuminate\Routing\Route;
use Illuminate\Support\Facades\Route;
use App\Models\SecGroup;
use App\Models\AccountLevel;
use Auth;
use View;
use Redirect;
class IController extends BaseController
{
    use AuthorizesRequests,
    DispatchesJobs,
    ValidatesRequests;
    var $metaTitle = "";
    protected $basic_methods = [
        'index' => 'Show table data',
        'show' => 'Show specific item',
        'edit' => 'Modify specific item',
        'create' => 'Create new item',
        'destroy' => 'Delete specific item',
    ];
    protected $post_methods = [
        'update' => 'edit',
        'store' => 'create',
    ];
    var $methods = [];
    var $postmethods = [];

    public function __construct() {
        $this->middleware('access');
        $this->middleware('ViewFilter', ['except' => 'export']); //

        $this->methods = array_merge($this->basic_methods, $this->methods);
        $this->postmethods = array_merge($this->post_methods, $this->postmethods);


        //$relates = [];
        //Posts Menu
        $cp_menu=[];
        foreach (\App\Models\PostType::where('can_use_menu', 1)->orderBy('sort')->get() as $key => $value) {
           // if (!array_key_exists($value->name, $cp_menu)) {



                $cp_menu[$value->name] = [
                    'childs' => [
                        'Add New' => [
                            'url' => route('cp.posts.create', ['post_type_id' => $value->id]),
                            'roles' => $value->Roles()->pluck('groupkey')->toArray(),
                            // ['admin'],
                            'icon' => 'fa-circle'
                        ],
                        'View All' => [
                            'url' => route('cp.posts.index', ['post_type_id' => $value->id]),
                            'roles' => $value->Roles()->pluck('groupkey')->toArray(),
                            // ['admin'],
                            'icon' => 'fa-circle'
                        ]
                    ],
                    //'url' => route('cp.posts.index', ['type' => $value->id]),
                    'roles' => $value->Roles()->pluck('groupkey')->toArray(),
                    // ['admin'],
                    'icon' => $value->icon

                ];

                /*foreach (\App\Models\PostTypeProperty::where('post_type_id', $value->id)->where('related_post_type_id', '>', 0)->get() as $related) {
                    $ptype = \App\Models\PostType::find($related->related_post_type_id);
                    $cp_menu[$related->name] = [
                        'url' => route('cp.posts.index', ['type' => $related->related_post_type_id]),
                        'roles' => $ptype->Roles()->pluck('groupkey')->toArray(),
                        // ['admin'],
                        'icon' => 'fa-circle'
                    ];
                    //$relates[] = $ptype->id;


                }*/
           // }
            //Setting Menu
            $cp_menu['System'] = [
                'icon' => 'fa-cog',
                'roles' => ['admin'],
                'childs' => [
                    'Category' => [
                        'url' => route('cp.category.index', null, false),
                        'roles' => ['admin'],
                        'icon' => 'fa fa-cubes',
                    ],
                    'Menus' => [
                        'url' => route('cp.menu.index'),
                        'roles' => ['admin'],
                        'icon' => 'fa-bars'
                    ],
                    'Translations' => [
                        'url' => route('cp.locales.index'),
                        'roles' => ['admin'],
                        'icon' => 'fa fa-globe'
                    ],
                    'Users' => [
                        'url' => route('cp.user.index'),
                        'roles' => ['admin'],
                        'icon' => 'fa-users'
                    ],
                    'Setting' => [
                        'url' => route('cp.setting.edit'),
                        'roles' => ['admin'],
                        'icon' => 'fa-cog'
                    ]
                ]
            ];
            //Setting Menu
            $cp_menu['Srcurity'] = [
                'icon' => 'fa-cog',
                'roles' => ['supperadmin'],
                'childs' => [
                    'Roles' => [
                        'url' => route('cp.secgroup.index', null, false),
                        'roles' => ['supperadmin'],
                        'icon' => 'fa fa-cubes',
                    ],
                    'Permissions' => [
                        'url' => route('cp.secpermission.index', null, false),
                        'roles' => ['supperadmin'],
                        'icon' => 'fa fa-cubes',
                    ],
                ],

            ];


            View::share('cp_menu', $cp_menu);
            View::share('sel_menu', null);
        }
    }

}