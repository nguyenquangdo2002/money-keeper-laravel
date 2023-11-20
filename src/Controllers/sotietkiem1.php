<?php
namespace Simcify\Controllers;

use Simcify\Database;
use Simcify\Auth;

class sotietkiem1{

    /**
     * Get income page view
     * 
     * @return \Pecee\Http\Response
     */
    public function get() {
        $title = __('pages.sections.income');
        $user = Auth::user();
        $stats = array();
        $sotietkiem = Database::table('sotietkiem')->where('user', $user->id)->orderBy("id", false)->get();
        $accounts = Database::table('accounts')->where('user', $user->id)->orderBy("id", false)->get();
        $categories = Database::table('categories')->where('user',$user->id)->where('type','expense')->orderBy("id", false)->get();
        $incomecategories = Database::table('categories')->where('user',$user->id)->where('type','Income')->orderBy("id", false)->get();
        $income = Database::table("income")->where("income`.`user", $user->id)->leftJoin("accounts", "income.account","accounts.id")->leftJoin("categories", "income.category","categories.id")->orderBy("income.id", false)->get("`income.id`", "`income.income_date`", "`income.category`", "`income.amount`","`income.danhba`", "`income.title`", "`accounts.name`", "`categories.name` as categoryname");
        $stats['earned'] = Database::table('income')->where('user', $user->id)->where('MONTH(`income_date`)', date("m"))->sum('amount','total')[0]->total;
        if ($user->monthly_earning > 0) {
          $stats['percentage'] = round(($stats['earned'] / $user->monthly_earning) * 100);
        }else{
          $stats['percentage'] = 0;
        }
        return view('sotietkiem1',compact("user","title","accounts","categories","incomecategories","income","stats", "sotietkiem"));
    }

    /**
     * Add Sổ tiết kiệm
     * 
     * @return Json
     */
    public function addSotietkiem1() {
      $user = Auth::user();
        $data = array(
          'user'=>$user->id,
          'tensotietkiem'=>escape(input('tensotietkiem')),
            'sodubandau'=>input('sodubandau'),
            'loaitiente'=>input('loaitiente'),
            'nganhang'=>input('nganhang'),
            'ngaygui'=>date('Y-m-d',strtotime(input('ngaygui'))),
            'kyhan'=>input('kyhan'),
            'laisuat'=>input('laisuat'),
            'laisuatkhongkyhan'=>input('laisuatkhongkyhan'),
            'songaytinhlaitrennam'=>input('songaytinhlaitrennam'),
            'tralai'=>input('tralai'),
            'khidenhan'=>input('khidenhan'),
            'account'=>input('account'),
            'diengiai'=>input('diengiai')
        );
        Database::table('sotietkiem')->insert($data);
        if (input('account') != "00") {
          self::balance(input('account'), input('amount'), "minus");
        }
        if (input('account') != "00") {
        $accountId = input('account');
        $amount = input('sodubandau'); // Số tiền của sổ tiết kiệm mới
        self::balance($accountId, $amount);
    }
        return response()->json(responder("success", __('pages.messages.alright'), __('sotietkiem1.messages.add-success'), "reload()"));
    }

    /**
     * Account balance
     * 
     * @return true
     */
 public function balance($accountId, $amount) {
    $account = Database::table('accounts')->where('id', $accountId)->first();
    $balance = $account->balance - $amount;
    Database::table('accounts')->where('id', $accountId)->update(['balance' => $balance]);
    return true;
}




    /**
     * Sổ tiết kiệm update modal
     * 
     * @return \Pecee\Http\Response
     */
    public function updateview() {
      $user = Auth::user();
      
      $accounts = Database::table('accounts')->where('user', $user->id)->orderBy("id", false)->get();
      $sotietkiem = Database::table('sotietkiem')->where('id', input("sotietkiemid"))->first();
      return view('includes/ajax/sotietkiem1',compact("sotietkiem","accounts","categories"));
  }

    /**
     * Update sổ tiết kiệm
     * 
     * @return Json
     */
    public function update(){
      $sotietkiem = Database::table('sotietkiem')->where('id', input("sotietkiemid"))->first();
      $user = Auth::user();
      $data = array(
          'user'=>$user->id,
          'tensotietkiem'=>escape(input('tensotietkiem')),
          'sodubandau'=>input('sodubandau'),
          'loaitiente'=>input('loaitiente'),
          'nganhang'=>input('nganhang'),
          'ngaygui'=>date('Y-m-d',strtotime(input('ngaygui'))),
          'kyhan'=>input('kyhan'),
          'laisuat'=>input('laisuat'),
          'laisuatkhongkyhan'=>input('laisuatkhongkyhan'),
          'songaytinhlaitrennam'=>input('songaytinhlaitrennam'),
          'tralai'=>input('tralai'),
          'khidenhan'=>input('khidenhan'),
          'account'=>input('account'),
          'diengiai'=>input('diengiai')
      );
     
      if (input('amount') != $sotietkiem->amount && $sotietkiem->account > 0) {
        self::balance($sotietkiem->account, $sotietkiem->amount, "minus");
        self::balance($sotietkiem->account, input('amount'), "plus");
      }

      Database::table('sotietkiem')->where('id',input('sotietkiemid'))->update($data);
      return response()->json(responder("success", __('pages.messages.alright'), __('sotietkiem1.messages.edit-success'), "reload()"));
    }

    /**
     * Delete income record
     * 
     * @return Json
     */
    public function delete(){
      $sotietkiem = Database::table('sotietkiem')->where('id', input("sotietkiemid"))->first();
      if (!empty($sotietkiem->account)) {
        self::balance($sotietkiem->account, $sotietkiem->amount, "plus");
      }
      Database::table('sotietkiem')->where('id',input('sotietkiemid'))->delete();
      return response()->json(responder("success", __('pages.messages.alright'), __('sotietkiem1.messages.delete-success'), "reload()"));
    }

    /**
     * Sổ tiết kiệm update modal
     * 
     * @return \Pecee\Http\Response
     */
    public function tattoan() {
      $user = Auth::user();
      $accounts = Database::table('accounts')->where('user', $user->id)->orderBy("id", false)->get();
      $sotietkiem = Database::table('sotietkiem')->where('id', input("sotietkiemid"))->first();
      $account = Database::table('accounts')->where('id', input("accountid"))->first();
      $totals = 0;
      if($sotietkiem->kyhan == 01 || $sotietkiem->kyhan == 02 ||$sotietkiem->kyhan == 03 ||$sotietkiem->kyhan == 04 ||$sotietkiem->kyhan == 05 ||$sotietkiem->kyhan == 06 ||$sotietkiem->kyhan == 07){
        $totals = ($sotietkiem->sodubandau * ($sotietkiem->laisuat/100)) + $sotietkiem->sodubandau;
      }else{
        $totals = ($sotietkiem->sodubandau * ($sotietkiem->laisuatkhongkyhan/100)) + $sotietkiem->sodubandau;
      }

      return view('includes/ajax/sotietkiem2',compact("sotietkiem","account","accounts","totals"));
  }

  // $totals = 0;
  //     if($sotietkiem->kyhan == 01 || $sotietkiem->kyhan == 02 ||$sotietkiem->kyhan == 03 ||$sotietkiem->kyhan == 04 ||$sotietkiem->kyhan == 05 ||$sotietkiem->kyhan == 06 ||$sotietkiem->kyhan == 07){
  //       $totals = ($sotietkiem->sodubandau * ($sotietkiem->laisuat/100)) + $sotietkiem->sodubandau;
  //     }else{
  //       $totals = ($sotietkiem->sodubandau * ($sotietkiem->laisuatkhongkyhan/100)) + $sotietkiem->sodubandau;
  //     }
      

    /**
     * Update account
     * 
     * @return Json
     */
    public function tattoanluon(){
      $data = array(
          'name'=>input('name'),
          'balance'=>input('balance'),
          'type'=>input('type'),
          'status'=>input('status')
      );
      Database::table('accounts')->where('id',input('accountid'))->update($data);
      return response()->json(responder("success", __('pages.messages.alright'), __('overview.messages.edit-success'), "reload()"));
  }


}
