<?php
namespace Simcify\Controllers;

use Simcify\Database;
use Simcify\Auth;

class Hanmuc{

    /**
     * Get income page view
     * 
     * @return \Pecee\Http\Response
     */
    public function get() {
        $stats = array();
        $title = __('pages.sections.sotietkiem');
        $user = Auth::user();
        $accounts = Database::table('accounts')->where('user', $user->id)->orderBy("id", false)->get();
        $categories = Database::table('categories')->where('user',$user->id)->where('type','expense')->orderBy("id", false)->get();
        $incomecategories = Database::table('categories')->where('user',$user->id)->where('type','income')->orderBy("id", false)->get();
        $hanmuc = Database::table("hanmuc")->where("hanmuc`.`user", $user->id)->leftJoin("accounts", "hanmuc.account","accounts.id")->leftJoin("categories", "hanmuc.id","categories.hanmuc")->get();
        // $hanmuc = Database::table('categories')->where("categories`.`user",$user->id)->leftJoin("hanmuc","categories.hanmuc","hanmuc.id")->leftJoin("expenses","categories.id","expenses.category")->where("type","expense")->get();
        $stats['spent'] = Database::table('expenses')->where('user', $user->id)->where('MONTH(`expense_date`)', date("m"))->sum('amount','total')[0]->total;
        $expenses = Database::table("expenses")->where("expenses`.`user", $user->id)->leftJoin("accounts", "expenses.account","accounts.id")->leftJoin("categories", "expenses.category","categories.id")->orderBy("expenses.id", false)->get("`expenses.id`", "`expenses.expense_date`", "`expenses.amount`", "`expenses.title`","`expenses.danhba`", "`accounts.name`", "`categories.name` as category");
        
        
        $stats['spent'] = Database::table('expenses')->where('user', $user->id)->where('MONTH(`expense_date`)', date("m"))->where('category',$hanmuc->id)->sum('amount','total')[0]->total;
        if ($user->monthly_spending > 0) {
          $stats['percentage'] = round(($stats['spent'] / $user->monthly_spending) * 100);
        }else{
          $stats['percentage'] = 0;
        }

        $hanmucs = Database::table('categories')->where("user", $user->id)->where('type','expense')->get();

        $hanmuc = new \StdClass();
        foreach($hanmucs as $hanmuc){
          $hanmuc->spent = Database::table('expenses')->where('category', $hanmuc->id)->where('MONTH(`expense_date`)', date("m"))->sum('amount','total')[0]->total;
          $hanmuc->lastmonth = Database::table('expenses')->where('category', $hanmuc->id)->where('MONTH(`expense_date`)', date("m") - 1)->sum('amount','total')[0]->total;
          $hanmuc->transactions = Database::table('expenses')->where('category', $hanmuc->id)->where('MONTH(`expense_date`)', date("m"))->count('id','total')[0]->total;
          $hanmuc->hanmuc = Database::table("hanmuc")->where("hanmuc`.`user", $user->id)->leftJoin("accounts", "hanmuc.account","accounts.id")->leftJoin("categories", "hanmuc.id","categories.hanmuc")->get();
      }
      
        return view('hanmuc',compact("user","hanmucs", "title", "stats", "accounts","expenses","stats","categories", "incomecategories","budgets"));
    }


    /**
     * Account balance
     * 
     * @return true
     */
    public function balance($accountId, $amount, $action) {
      $account = Database::table('accounts')->where('id', $accountId)->first();
      if ($action == "plus") {
        $balance = $account->balance + $amount;
      }elseif ($action == "minus") {
        $balance = $account->balance - $amount;
      }
      Database::table('accounts')->where('id', $accountId)->update(array("balance" => $balance));
      return true;
    }


    /**
     * Hạn mức update modal
     * 
     * @return \Pecee\Http\Response
     */
    public function updateview() {
      $user = Auth::user();
      $categories = Database::table('categories')->where('user',$user->id)->where('type','hanmuc')->get();
      $accounts = Database::table('accounts')->where('user', $user->id)->orderBy("id", false)->get();
      $hanmuc = Database::table('hanmuc')->where('id', input("hanmucid"))->first();
      return view('includes/ajax/hanmuc',compact("hanmuc","accounts","categories"));
  }

    /**
     * Delete hạn mức
     * 
     * @return Json
     */
    public function delete(){
        $hanmucs = Database::table('hanmuc')->where('id', input("hanmucid"))->first();
        Database::table('hanmuc')->where('id',input('hanmucid'))->delete();
        return response()->json(responder("success", __('pages.messages.alright'), __('expenses.messages.delete-success'), "reload()"));
      }

      /**
     * Update hạn mức
     * 
     * @return Json
     */
    public function update(){
      $hanmuc = Database::table('hanmuc')->where('id', input("hanmucid"))->first();
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
      if (input('sotienhanmuc') != $hanmuc->sotienhanmuc && $hanmuc->sotienhanmuc > 0) {
        self::balance($hanmuc->account, $hanmuc->sotienhanmuc, "minus");
        self::balance($hanmuc->sotienhanmuc, input('sotienhanmuc'), "plus");
      }
      Database::table('hanmuc')->where('id',input('hanmucid'))->update($data);
      return response()->json(responder("success", __('pages.messages.alright'), __('expenses.messages.edit-success'), "reload()"));
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
