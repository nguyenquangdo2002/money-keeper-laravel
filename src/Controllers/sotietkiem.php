<?php
namespace Simcify\Controllers;

use Simcify\Database;
use Simcify\Auth;

class sotietkiem{

    /**
     * Get income page view
     * 
     * @return \Pecee\Http\Response
     */
    public function get() {
        $stats = array();
        $title = __('pages.sections.expenses');
        $user = Auth::user();
        $accounts = Database::table('accounts')->where('user', $user->id)->orderBy("id", false)->get();
        $categories = Database::table('categories')->where('user',$user->id)->where('type','expense')->orderBy("id", false)->get();
        $incomecategories = Database::table('categories')->where('user',$user->id)->where('type','income')->orderBy("id", false)->get();
        $hanmucs = Database::table("hanmuc")->where("hanmuc`.`user", $user->id)->leftJoin("accounts", "hanmuc.account","accounts.id")->leftJoin("categories", "hanmuc.category","categories.id")->orderBy("hanmuc.id", false)->get("`hanmuc.id`", "`hanmuc.start_date`","`hanmuc.end_date`", "`hanmuc.sotienhanmuc`", "`hanmuc.tenhanmuc`", "`accounts.name`", "`categories.name` as categoryname");
        $expenses = Database::table("expenses")->where("expenses`.`user", $user->id)->leftJoin("accounts", "expenses.account","accounts.id")->leftJoin("categories", "expenses.category","categories.id")->orderBy("expenses.id", false)->get("`expenses.id`", "`expenses.expense_date`", "`expenses.amount`", "`expenses.title`","`expenses.danhba`", "`accounts.name`", "`categories.name` as category");
        $stats['spent'] = Database::table('expenses')->where('user', $user->id)->where('MONTH(`expense_date`)', date("m"))->sum('amount','total')[0]->total;
        if ($user->monthly_spending > 0) {
          $stats['percentage'] = round(($stats['spent'] / $user->monthly_spending) * 100);
        }else{
          $stats['percentage'] = 0;
        }
        return view('sotietkiem',compact("user", "title", "hanmucs", "stats", "accounts","expenses","stats","categories", "incomecategories"));
    }


    /**
     * Delete expense record
     * 
     * @return Json
     */
    public function delete(){
        $hanmucs = Database::table('hanmuc')->where('id', input("hanmucid"))->first();
        Database::table('hanmuc')->where('id',input('hanmucid'))->delete();
        return response()->json(responder("success", __('pages.messages.alright'), __('expenses.messages.delete-success'), "reload()"));
      }


    /**
     * Ghi chú
     * Thêm Hạn mức
     * 
     * @return Json
     */
    public function addHanmuc() {
        $user = Auth::user();
        $data = array(
            'tenhanmuc'=>escape(input('tenhanmuc')),
            'user'=>$user->id,
            'sotienhanmuc'=>input('sotienhanmuc'),
            'account'=>input('account'),
            'category'=>input('category'),
            'start_date'=>date('Y-m-d',strtotime(input('start_date'))),
            'end_date'=>date('Y-m-d',strtotime(input('end_date')))
        );
        Database::table('hanmuc')->insert($data);
        return response()->json(responder("success", __('pages.messages.alright'), __('overview.messages.add-success'), "reload()"));
      }

      
}
