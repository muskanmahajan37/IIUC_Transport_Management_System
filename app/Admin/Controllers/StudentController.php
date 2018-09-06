<?php

namespace App\Admin\Controllers;

use App\Http\Controllers\Controller;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;

use App\User;
use DB;
use Encore\Admin\Controllers\HasResourceActions;


class StudentController extends Controller
{
    use HasResourceActions;
    /**
     * Index interface.
     *
     * @return Content
     */
    public function index(Content $content)
    {
        return $content
           ->header(trans('Users'))
            ->description(trans('Student List'))
            ->body($this->grid(1)->render());
    }


    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid($value)
    {
        $self = $this;
        return User::grid(function (Grid $grid) use ($value,$self) {


            $grid->model()->where('userrole', '=', $value);
            $grid->id('ID')->sortable();
            $grid->jobid(trans('Varsity ID'))->sortable();
            $grid->image(trans('admin.avatar'))->display(function ($s) use ($self) {
                $file= $self->imageValidate($this->jobid);  //I want to use this $file value
                if($file){ // here I want to access $file
                    return "<img style='max-width:100px;max-height:100px' class='img img-thumbnail' src='http://upanel.iiuc.ac.bd:81/Picture/" . $this->jobid . ".jpg' alt='" . $this->name . "'/>";
                } else {
                    return "<img style='max-width:100px;max-height:100px' class='img img-thumbnail' src='/storage/image/user/" . $this->image . "' alt='" . $this->name . "'/>";
                }
            });
            $grid->name(trans('Name'));
            $grid->email(trans('Email'));
            $grid->gender(trans('Gender'))->display(function ($s) {
                return $s ? 'Female' : 'Male';
            });

            $grid->confirmed(trans('Activated'))->display(function ($s) {
                return $s ? 'Yes' : 'No';
            })->label();
            $grid->confirmation(trans('Verified'))->display(function ($s) {
                return $s ? 'Yes' : 'No';
            })->label();
            $grid->created_at(trans('Member Since'));
            $grid->updated_at(trans('Last Updated'));

            $grid->actions(function (Grid\Displayers\Actions $actions) {
                if ($actions->getKey() == 1) {
                    $actions->disableDelete();
                }
//                $actions->disableEdit();
                $actions->disableview();
            });

            $grid->tools(function (Grid\Tools $tools) {
                $tools->batch(function (Grid\Tools\BatchActions $actions) {
                    $actions->disableDelete();
                });
            });
            $grid->filter(function ($filter) {
                // Sets the range query for the created_at field
                $filter->between('jobid', 'Search by Varsity ID');
            });

            $grid->disableCreateButton();
            $grid->perPages([10, 15, 20, 25, 30, 35, 40, 45, 50, 100]);


        });
    }


    /**
     * Edit interface.
     *
     * @param $id
     * @return Content
     */
    public function edit($id, Content $content)
    {
        return $content
            ->header(trans('User'))
            ->description(trans('admin.edit'))
            ->body($this->form()->edit($id));
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    public function form()
    {
        $self = $this;
        $form = new Form(new User());

        $form->display('id', 'ID');
        $form->display('jobid', 'Varsity ID');
        $form->display('avatar', trans('admin.avatar'))->with(function ($s) use ($self){
            $url = "http://upanel.iiuc.ac.bd:81/Picture/" . $this->jobid . ".jpg";
            $ch = curl_init();
            $timeout = 5;
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);

            $lines_string = curl_exec($ch);
            $retcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);
            $file2 = $lines_string;
            $file = $retcode;
            if ($file == 200 && $file2[0] != '<') {
//            $file = $self->imageValidate($this->jobid);
//            if($file){
                return "<img style='max-height:100px; max-width:100px;' src='http://upanel.iiuc.ac.bd:81/Picture/" . $this->jobid . ".jpg' alt='" . $this->name . "'/>";
            } else {
                return "<img style='max-height:100px; max-width:100px;' src='/storage/image/user/" . $this->image . "' alt='" . $this->name . "'/>";
            }
        });
        $form->display('name', trans('admin.name'))->rules('required');
        $form->display('email', trans('Email'))->rules('required');
        $form->display('gender',trans('Gender'))->with(function ($s){
            return $s? 'Female':'Male';
        });
        $form->display('confirmed', trans('Activated'))->with(function ($s){
            return $s? 'Yes':'No';
        });

        $form->radio('confirmation', 'Verified')->options([0 => 'No', 1 => 'Yes'])->stacked();
        $form->display('created_at', trans('Member Since'));
        $form->display('updated_at', trans('Last Updated'));
        $form->tools(function (Form\Tools $tools) {
            // Add a button, the argument can be a string, or an instance of the object that implements the Renderable or Htmlable interface
            //$tools->append('<a onclick="window.history.back()" class="btn btn-sm btn-primary"><i class="fa fa-arrow-left"></i>&nbsp;&nbsp;Back</a>');
            // Disable list btn
            //$tools->disableList();
            $tools->disableDelete();
            $tools->disableView();
        });

        $form->save();

        return $form;
    }


    protected function imageValidate($pic){
        $url = "http://upanel.iiuc.ac.bd:81/Picture/" . $pic . ".jpg";
        $ch = curl_init();
        $timeout = 5;
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);

        $lines_string = curl_exec($ch);
        $retcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        $file2 = $lines_string;
        $file = $retcode;
        if ($file == 200 && $file2[0] != '<') {
            return true;
        } else {
            return false;
        }
    }
}
