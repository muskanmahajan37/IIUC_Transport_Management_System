<?php

namespace App\Admin\Controllers;

use App\Helper;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;

class HelperInfoController extends Controller
{
    use HasResourceActions;

    /**
     * Index interface.
     *
     * @param Content $content
     * @return Content
     */
    public function index(Content $content)
    {
        return $content
            ->header('Helper Information')
            ->description('List')
            ->body($this->grid());
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Helper);

        //$grid->id('ID')->sortable();
        $states = [
            'on' => ['value' => 1, 'text' => 'YES', 'color' => 'success'],
            'off' => ['value' => 0, 'text' => 'NO', 'color' => 'danger'],
        ];
        $grid->active('Available')->switch($states)->sortable();
        $grid->image('Photo')->display(function ($s) {
            return "<img style='max-width:100px;max-height:100px' class='img img-thumbnail' src='/storage/" . $s . "' alt='" . $this->name . "'/>";
        });
        $grid->name('Name')->sortable()->badge("green");
//        $grid->gender('Gender')->display(function ($s) {
//            return $s ? 'Female' : 'Male';
//        });
        $grid->nid('NID')->badge("blue")->sortable();
        $grid->helperid('Helper ID')->sortable()->badge("purple");
//        $grid->licensepic('License Photo')->display(function ($s) {
//            return "<img style='max-width:100px;max-height:100px' class='img img-thumbnail' src='/storage/" . $s . "' alt='" . $this->name . "'/>";
//        });
        $grid->license('License No')->sortable()->badge("purple");
        $grid->contactno('Contact No');
        $grid->busno('Bus No')->sortable();
        $grid->join_date('Join Date')->sortable();
        //$grid->address('Address');

        //$grid->created_at('Created At');
        $grid->updated_at('Updated At')->sortable();

        $grid->filter(function ($filter) {
            // Sets the range query for the created_at field
            //$filter->expand();
            $filter->disableIdFilter();
            $filter->like('nid', 'NID');
            $filter->like('helperid', 'Helper ID');
            $filter->like('license', 'License No');
        });

        return $grid;
    }

    /**
     * Show interface.
     *
     * @param mixed $id
     * @param Content $content
     * @return Content
     */
    public function show($id, Content $content)
    {
        return $content
            ->header('Detail')
            ->description(' ')
            ->body($this->detail($id));
    }

    /**
     * Make a show builder.
     *
     * @param mixed $id
     * @return Show
     */
    protected function detail($id)
    {
        $show = new Show(Helper::findOrFail($id));

        $show->panel()
            ->title(trans('Helper Details'));

        $show->id('ID');
        $show->image('Photo')->image();
//            ->as(function ($s) {
//            return "<img style='max-width:200px;max-height:200px' class='img img-thumbnail' src='/storage/" . $s . "' alt='" . $this->name . "'/>";
//        });
        $show->name('Name');
        $show->gender('Gender')->as(function ($s) {
            return $s ? 'Female' : 'Male';
        });
        $show->nid('NID');
        $show->helperid('Helper ID');
        $show->licensepic('License Photo')->image();
//        ->as(function ($s) {
//            return "<img style='max-width:200px;max-height:200px' class='img img-thumbnail' src='/storage/" . $s . "' alt='" . $this->name . "'/>";
//        });
        $show->license('License No');
        $show->contactno('Contact No');
        $show->busno('Bus No');
        $show->address('Address');
        $show->created_at('Created At');
        $show->updated_at('Updated At');

        return $show;
    }

    /**
     * Edit interface.
     *
     * @param mixed $id
     * @param Content $content
     * @return Content
     */
    public function edit($id, Content $content)
    {
        return $content
            ->header('Edit')
            ->description(' ')
            ->body($this->form()->edit($id));
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Helper);

        $form->text('name', 'Name')->rules('required');
        $form->image('image', 'Photo')->uniqueName()->default('defaultAdmin.png')->rules('required');
        $form->text('nid', 'NID')->rules('required');
        $form->text('helperid', 'Helper ID')->rules('required');
        // change upload path ->move('/storage/images/Driver/')
        $form->image('licensepic', 'License Photo')->uniqueName()->rules('required');
        // use a unique name (md5(uniqid()).extension)
        //$form->image('licensepic')->uniqueName();
        //$form->image('licensepic', 'Licensepic');
        $form->text('license', 'License')->rules('required');
        $form->text('contactno', 'Contact No')->rules('required');
        $form->text('busno', 'Bus No')->rules('required');
        $form->textarea('address', 'Address')->rules('required');
        $form->radio('gender', 'Gender')->options([0 => 'Male', 1 => 'Female'])->stacked()->rules('required');
        $form->date('join_date', 'Join Date');
        $states = [
            'on' => ['value' => 1, 'text' => 'Yes', 'color' => 'success'],
            'off' => ['value' => 0, 'text' => 'No', 'color' => 'danger'],
        ];
        $form->switch('active', 'Available')->states($states)->default(false);
        return $form;
    }

    /**
     * Create interface.
     *
     * @param Content $content
     * @return Content
     */
    public function create(Content $content)
    {
        return $content
            ->header('Add New Helper')
            ->description(' ')
            ->body($this->form());
    }
}
