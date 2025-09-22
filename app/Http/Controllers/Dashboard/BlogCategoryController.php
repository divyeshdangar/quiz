<?php

namespace App\Http\Controllers\Dashboard;


use Illuminate\Http\RedirectResponse;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BlogCategories;
use Illuminate\Support\Facades\Validator;

class BlogCategoryController extends Controller
{
    public function index(Request $request)
    {
        $metaData = [
            "breadCrumb" => [
                ["title" => "Blog Category", "route" => ""],
            ],
            "title" => "Blog Categories List"
        ];
        $dataList = BlogCategories::orderBy('id', 'DESC');
        $dataList = $dataList->searching()->paginate(10)->withQueryString();
        return view('dashboard.blog-category.index', ['dataList' => $dataList, 'metaData' => $metaData]);
    }

    public function view(Request $request, $id)
    {
        $dataDetail = BlogCategories::find($id);
        if ($dataDetail) {
            $metaData = [
                "breadCrumb" => [
                    ["title" => "Blog Category", "route" => "dashboard.blog.category"],
                    ["title" => $dataDetail->title, "route" => ""],
                ],
                "title" => $dataDetail->title
            ];
            return view('dashboard.blog-category.view', ['dataDetail' => $dataDetail, 'metaData' => $metaData]);
        } else {
            $message = [
                "message" => [
                    "type" => "error",
                    "title" => __('dashboard.bad'),
                    "description" => __('dashboard.no_record_found')
                ]
            ];
            return redirect()->route('dashboard')->with($message);
        }
    }

    public function create(Request $request)
    {
        $metaData = [
            "breadCrumb" => [
                ["title" => "Blog Category", "route" => "dashboard.blog.category"],
                ["title" => "Edit", "route" => ""],
            ],
            "title" => "Create"
        ];
        $categoryData = BlogCategories::orderBy('title')->get();
        return view('dashboard.blog-category.create', ['categoryData' => $categoryData, 'metaData' => $metaData]);
    }

    public function edit(Request $request, $id)
    {
        $dataDetail = BlogCategories::find($id);
        if ($dataDetail) {
            $metaData = [
                "breadCrumb" => [
                    ["title" => "Blog Category", "route" => "dashboard.blog.category"],
                    ["title" => "Edit", "route" => ""],
                ],
                "title" => $dataDetail->title
            ];
            $categoryData = BlogCategories::orderBy('title')->get();
            return view('dashboard.blog-category.edit', ['dataDetail' => $dataDetail, 'categoryData' => $categoryData, 'metaData' => $metaData]);
        } else {
            $message = [
                "message" => [
                    "type" => "error",
                    "title" => __('dashboard.bad'),
                    "description" => __('dashboard.no_record_found')
                ]
            ];
            return redirect()->route('dashboard')->with($message);
        }
    }

    public function store(Request $request, $id): RedirectResponse
    {
        $dataDetail = BlogCategories::find($id);
        if ($dataDetail || $id == 0) {
            if($id == 0){
                $dataDetail = new BlogCategories();
            }

            $validator = Validator::make($request->all(), [
                'title' => 'required|max:255',
                'slug' => ['required', 'unique:blogs,slug,' . $id, 'min:5', 'max:255', 'regex:/^[a-z][a-z0-9]*(-[a-z0-9]+)*$/i'],
                'meta_description' => 'required',
                'description' => 'required',
                'parent_id' => 'sometimes',
            ]);

            if ($validator->fails()) {
                if($id == 0){
                    return redirect('dashboard/blog-category/create')->withErrors($validator)->withInput();
                } else {
                    return redirect('dashboard/blog-category/edit/' . $id)->withErrors($validator)->withInput();
                }
            }

            $dataToInsert = $validator->validated();
            if ($request->croppedImage != null) {
                $croped_image = $request->croppedImage;
                list($type, $croped_image) = explode(';', $croped_image);
                list(, $croped_image)      = explode(',', $croped_image);
                $croped_image = base64_decode($croped_image);
                $image_name = $dataDetail->slug."-".time().".png";
                file_put_contents("./images/blog-category/" . $image_name, $croped_image);
                $dataDetail->image = $image_name;
            }

            $dataDetail->title = $dataToInsert['title'];
            $dataDetail->description = $dataToInsert['description'];
            $dataDetail->meta_description = $dataToInsert['meta_description'];
            //$dataDetail->parent_id = ($dataToInsert['parent_id']) ? $dataToInsert['parent_id'] : null;
            if($id == 0){
                $dataDetail->slug = $dataToInsert['slug'];
            }
            $dataDetail->save();

            $message = [
                "message" => [
                    "type" => "success",
                    "title" => __('dashboard.great'),
                    "description" => __('dashboard.details_submitted')
                ]
            ];
            return redirect()->route('dashboard.blog.category')->with($message);
        } else {
            return redirect()->route('dashboard.blog.category');
        }
    }


    public function delete(Request $request, $id)
    {
        $dataDetail = BlogCategories::find($id);
        if ($dataDetail) {
            $dataDetail->delete();
            return redirect()->route('dashboard.blog.category');
        } else {
            $message = [
                "message" => [
                    "type" => "error",
                    "title" => __('dashboard.bad'),
                    "description" => __('dashboard.no_record_found')
                ]
            ];
            return redirect()->route('dashboard.blog.category')->with($message);
        }
    }
}
