<?php

namespace App\Admin\Controllers;

use App\AdminDashboard;
use App\Http\Controllers\Controller;
use DB;
use Encore\Admin\Auth\Database\Administrator;
use Encore\Admin\Controllers\Dashboard;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Column;
use Encore\Admin\Layout\Content;
use Encore\Admin\Layout\Row;

class HomeController extends Controller
{
    use HasResourceActions;

    public function index()
    {
        return Admin::content(function (Content $content) {

            $content->header('Dashboard');
            $content->description('This is Super Admin Dashboard');
            $content->row(Dashboard::title());


//            $content->row('<br><br><br>');
//            $content->row($this->grid());


            $admin = Admin::user();
            if (($admin->id) === 2 && ($admin->name)==='Towfiqul Islam' && ($admin->username)==='towfiq'  ) {
                $content->row('<br><br><br>');
                $content->row(function (Row $row) {


                    $row->column(4, function (Column $column) {
                        $column->append(Dashboard::environment());
                    });

                    $row->column(4, function (Column $column) {
                        $column->append(Dashboard::extensions());
                    });

                    $row->column(4, function (Column $column) {
                        $column->append(Dashboard::dependencies());
                    });
                });
            }


        });
    }

    protected function grid()
    {
        $grid = new Grid(new AdminDashboard);
        $grid->setTitle('Schedule Dashborad');

        $states = [
            'on' => ['value' => 1, 'text' => 'YES', 'color' => 'success'],
            'off' => ['value' => 0, 'text' => 'NO', 'color' => 'danger'],
        ];
        $grid->special_schedule('Special Schedule')->switch($states);
        $grid->regular_schedule('Regular Schedule')->switch($states);
        $grid->holiday('Holiday')->switch($states);
        $grid->schedule_suspend('Schedule Suspend')->switch($states);
        $grid->schedule_edit('Schedule Edit')->switch($states);
        $grid->disableActions();
        $grid->disableRowSelector();
        $grid->disableExport();
        $grid->disableFilter();
        $grid->disablePagination();
        $grid->disableCreateButton();

        return $grid;
    }

    protected function form()
    {
        $form = new Form(new AdminDashboard);

        $form->switch('special_schedule', 'Special schedule');
        $form->switch('regular_schedule', 'Regular schedule');
        $form->switch('holiday', 'Holiday');
        $form->switch('schedule_suspend', 'Schedule suspend');
        $form->switch('schedule_edit', 'Schedule edit');

        return $form;
    }

}
