<?php

    namespace ManaCMS\ManaCategories\Http\Controllers\Admin;

    use Illuminate\Session\Store;
    use Illuminate\Support\Facades\Validator;
    use ManaCMS\ManaCategories\Http\Controllers\Controller;
    use ManaCMS\ManaCategories\Http\Requests\StoreCategory;
    use ManaCMS\ManaCategories\Models\Categorizable;
    use ManaCMS\ManaCategories\Models\Category;
    use Illuminate\Http\Request;

    class CategoryController extends Controller
    {
        /**
         * Display a listing of the resource.
         *
         * @return \Illuminate\Http\Response
         */
        public function index()
        {
            $categories = Category::whereNull('parent_id')->with('moreChilds')->get()->keyBy('id');
            return view('categories::admin.index',compact('categories'));
        }

        /**
         * Show the form for creating a new resource.
         *
         * @return \Illuminate\Http\Response
         */
        public function create()
        {
            $categories = Category::whereNull('parent_id')->with('moreChilds')->get()->keyBy('id');
            return view('categories::admin.create',compact('categories'));
        }

        /**
         * Store a newly created resource in storage.
         *
         * @param  \Illuminate\Http\Request  $request
         * @return \Illuminate\Http\RedirectResponse
         */
        public function store(StoreCategory $request)
        {
            $request = json_decode(json_encode($request->validated()));
            if ($request->parent == 'noparent') {
                list($request->parent, $request->level) = [null,0];
            }
            else {
                list($request->parent, $request->level) = explode('#',$request->parent);
                $request->level += 1;
            }
            Category::create([
                'level' => $request->level,
                'parent_id' => $request->parent,
                'slug' => $request->slug,
                'title' => $request->title,
                'desc' => $request->description,
            ]);
            return redirect()->route('manage.category.index')->with('success',"دسته بندی «{$request->title}» با موفقیت ایجاد شد.")->with('title','تبریک!');

        }

        /**
         * Display the specified resource.
         *
         * @param  \App\Models\Category  $category
         * @return \Illuminate\Http\Response
         */
        public function show(Category $category)
        {
            //
            return 'show@CategoryController';
        }

        /**
         * Show the form for editing the specified resource.
         *
         * @param  \App\Models\Category  $category
         * @return \Illuminate\Http\Response
         */
        public function edit(Category $category)
        {
            $categories = Category::whereNull('parent_id')->with('childs.childs')->get()->keyBy('id');
            return view('categories::admin.create',compact('category','categories'));
        }

        /**
         * Update the specified resource in storage.
         *
         * @param  \Illuminate\Http\Request  $request
         * @param  \App\Models\Category  $category
         * @return \Illuminate\Http\RedirectResponse
         */
        public function update(StoreCategory $request, Category $category)
        {
            $request = json_decode(json_encode($request->validated()));
            if ($request->parent == 'noparent') {
                list($request->parent, $request->level) = [null,0];
            }
            else {
                list($request->parent, $request->level) = explode('#',$request->parent);
                $request->level += 1;
            }

            $category->title = $request->title;
            $category->slug = $request->slug;
            $category->desc = $request->description;
            $category->level = $request->level;
            $category->parent_id = $request->parent;
            $category->save();
            return redirect()->route('manage.category.index')->with('success',"دسته بندی «{$request->title}» با موفقیت بروزرسانی شد.")->with('title','تبریک!');
        }

        /**
         * Remove the specified resource from storage.
         *
         * @param  \App\Models\Category  $category
         * @return \Illuminate\Http\RedirectResponse
         */
        public function destroy(Category $category)
        {
            Categorizable::where('category_id',$category->id)->delete();
            $category->delete();
            return back()->with('success',"دسته بندی «{$category->title}» با موفقیت حذف شد.")->with('title','حذف موفقیت آمیز!');
        }
    }
