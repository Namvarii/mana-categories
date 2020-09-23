<?php

    namespace ManaCMS\ManaCategories\Http\Controllers\Admin;

    use Maatwebsite\Excel\Facades\Excel;
    use ManaCMS\ManaCategories\Http\Controllers\Controller;
    use ManaCMS\ManaCategories\Exports\CategoryExport;
    use ManaCMS\ManaCategories\Imports\CategoryImport;
    use Illuminate\Http\Request;

    class CategoryBatchController extends Controller
    {

        public function export()
        {
            return Excel::download(new CategoryExport,'post_categories_'.now().'.xlsx');
        }

        /**
         * Show the form for creating a new resource.
         *
         * @return \Illuminate\Http\Response
         */
        public function create()
        {
            return view('categories::admin.batch')
                ->with([
                    'title' => 'افزودن دسته جمعی دسته بندی های مطالب'
                ]);
        }

        /**
         * Store a newly created resource in storage.
         *
         * @param  \Illuminate\Http\Request  $request
         * @return \Illuminate\Http\RedirectResponse
         */
        public function store(Request $request)
        {
            $request->validate([
                'excel_file'=> 'required|file',
            ]);
            if ($request->excel_file->getClientOriginalExtension() == 'xlsx') {
//            DB::table('posts')->truncate();
                Excel::import(new CategoryImport, $request->file('excel_file'));
                return redirect()->route('manage.category.index')->with([
                    'title' => 'تبریک!',
                    'success' => 'با موفقیت دسته بندی ها اضافه گردید.'
                ]);
            }
            return back()->with([
                'title' => 'متاسفیم!',
                'error'=> 'فایل ارسالی فایل ایکسل مناسبی نیست.'
            ]);
        }

    }
