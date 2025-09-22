<?php

namespace App\Http\Controllers\Dashboard;

use App\Helpers\CommonHelper;
use Illuminate\Http\RedirectResponse;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Blog;
use App\Models\BlogCategories;
use Illuminate\Support\Facades\Validator;

class BlogController extends Controller
{
    public function index(Request $request)
    {
        $metaData = [
            "breadCrumb" => [
                ["title" => "Blog", "route" => ""],
            ],
            "title" => "Blog List"
        ];
        $dataList = Blog::orderBy('id', 'DESC');
        $dataList = $dataList->searching()->paginate(10)->withQueryString();
        return view('dashboard.blog.index', ['dataList' => $dataList, 'metaData' => $metaData]);
    }

    public function view(Request $request, $id)
    {
        $dataDetail = Blog::find(CommonHelper::decUrlParam($id));
        if ($dataDetail) {
            $metaData = [
                "breadCrumb" => [
                    ["title" => "Blog", "route" => "dashboard.blog"],
                    ["title" => "Detail", "route" => ""]
                ],
                "title" => "Blog Detail"
            ];
            return view('dashboard.blog.view', ['dataDetail' => $dataDetail, 'metaData' => $metaData]);
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
                ["title" => "Blog", "route" => "dashboard.blog"],
                ["title" => "Create", "route" => ""]
            ],
            "title" => "Create Blog"
        ];
        $categoryData = BlogCategories::orderBy('title')->get();
        return view('dashboard.blog.create', ['metaData' => $metaData, 'categoryData' => $categoryData]);
    }

    public function edit(Request $request, $id)
    {
        $dataDetail = Blog::find(CommonHelper::decUrlParam($id));
        if ($dataDetail) {
            $categoryData = BlogCategories::orderBy('title')->get();
            return view('dashboard.blog.edit', ['dataDetail' => $dataDetail, 'categoryData' => $categoryData, 'metaData' => []]);
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
        $id = CommonHelper::decUrlParam($id);
        $dataDetail = Blog::find($id);
        if ($dataDetail || $id == 0) {
            if ($id == 0) {
                $dataDetail = new Blog();
            }
            $validator = Validator::make($request->all(), [
                'title' => 'required|max:255',
                'slug' => ['required', 'unique:blogs,slug,' . $id, 'min:5', 'max:255', 'regex:/^[a-z][a-z0-9]*(-[a-z0-9]+)*$/i'],
                'meta_description' => 'required',
                'description' => 'required',
                'category_id' => 'required',
            ]);

            if ($validator->fails()) {
                if($id > 0) {
                    return redirect('dashboard/blog/edit/' . $id)->withErrors($validator)->withInput();
                } else {
                    return redirect('dashboard/blog/create')->withErrors($validator)->withInput();
                }
            }

            $dataToInsert = $validator->validated();

            if ($request->croppedImage != null) {
                $croped_image = $request->croppedImage;
                list($type, $croped_image) = explode(';', $croped_image);
                list(, $croped_image)      = explode(',', $croped_image);
                $croped_image = base64_decode($croped_image);
                $image_name = $dataToInsert['slug'].".png"; //time() . rand(10000000, 999999999) . '.png';
                file_put_contents("./images/blog/" . $image_name, $croped_image);
                $dataDetail->image = $image_name;
            }

            $dataDetail->title = $dataToInsert['title'];
            $dataDetail->description = $dataToInsert['description'];
            $dataDetail->slug = $dataToInsert['slug'];
            $dataDetail->meta_description = $dataToInsert['meta_description'];
            $dataDetail->category_id = $dataToInsert['category_id'];
            $dataDetail->latitude = "";
            $dataDetail->longitude = "";
            $dataDetail->save();

            $message = [
                "message" => [
                    "type" => "success",
                    "title" => __('dashboard.great'),
                    "description" => __('dashboard.details_submitted')
                ]
            ];
            return redirect()->route('dashboard.blog')->with($message);
        } else {
            return redirect()->route('dashboard.blog');
        }
    }

    public function delete(Request $request, $id)
    {        
        $dataDetail = Blog::find(CommonHelper::decUrlParam($id));
        if ($dataDetail) {
            $dataDetail->delete();
            $message = [
                "message" => [
                    "type" => "success",
                    "title" => __('dashboard.great'),
                    "description" => __('dashboard.record_deleted')
                ]
            ];
            return redirect()->route('dashboard.blog')->with($message);
        } else {
            $message = [
                "message" => [
                    "type" => "error",
                    "title" => __('dashboard.bad'),
                    "description" => __('dashboard.no_record_found')
                ]
            ];
            return redirect()->route('dashboard.blog')->with($message);
        }
    }
}
