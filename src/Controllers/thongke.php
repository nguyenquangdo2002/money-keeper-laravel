<?php
namespace Simcify\Controllers;
use Simcify\Database;
use Simcify\Auth;

class thongke{

    /**
     * Get a sample view or redirect to it
     * 
     * @return \Pecee\Http\Response
     */
    public function get() {
        $stats = array();
        $title = __('pages.sections.thongke');
        $user = Auth::user();
        $accounts = Database::table('accounts')->where('user', $user->id)->orderBy("id", false)->get();
        $categories = Database::table('categories')->where('user',$user->id)->where('type','expense')->orderBy("id", false)->get();
        $incomecategories = Database::table('categories')->where('user',$user->id)->where('type','income')->orderBy("id", false)->get();
        $account = new \StdClass();
        foreach ($accounts as $account) {
            $incomeTransactions = Database::table('income')->where('account', $account->id)->count('id','total')[0]->total;
            $expenseTransactions = Database::table('expenses')->where('account', $account->id)->count('id','total')[0]->total;
            $account->transactions = $incomeTransactions + $expenseTransactions;
        }

        $stats['spent'] = Database::table('expenses')->where('user', $user->id)->where('MONTH(`expense_date`)', date("m"))->sum('amount','total')[0]->total;
        if ($user->monthly_spending > 0) {
          $stats['percentage'] = round(($stats['spent'] / $user->monthly_spending) * 100);
        }else{
          $stats['percentage'] = 0;
        }

        $stats['income'] = Database::table('income')->where('user', $user->id)->where('MONTH(`income_date`)', date("m"))->sum('amount','total')[0]->total;
        $stats['expenses'] = Database::table('expenses')->where('user', $user->id)->where('MONTH(`expense_date`)', date("m"))->sum('amount','total')[0]->total;
        if ($stats['expenses'] > $stats['income']) {
            $stats['savings'] = 0;
        }else{
            $stats['savings'] = $stats['income'] - $stats['expenses'];
        }
        $stats['incomeTransactions'] = Database::table('income')->where('user', $user->id)->where('MONTH(`income_date`)', date("m"))->count('id','total')[0]->total;
        $stats['expenseTransactions'] = Database::table('expenses')->where('user', $user->id)->where('MONTH(`expense_date`)', date("m"))->count('id','total')[0]->total;
        $totalTransactions = $stats['incomeTransactions'] + $stats['expenseTransactions'];
        if ($totalTransactions > 0) {
          $stats['incomePercentage'] = round(($stats['incomeTransactions'] / $totalTransactions) * 100);
          $stats['expensePercentage'] = round(($stats['expenseTransactions'] / $totalTransactions) * 100);
        }else{
          $stats['incomePercentage'] = 0;
          $stats['expensePercentage'] = 0;
        }
        $reports = self::reports(date('Y-m-d', strtotime('today - 30 days')).' 23:59:59', date('Y-m-d').' 00:00:00');

        return view('thongke',compact("user","accounts","categories","incomecategories","title","stats","reports"));
    }

    

    /**
     * Report
     * 
     * @return array
     */
    public function reports($from, $to){
        $reports = array();
        $user = Auth::user();
        $range = $from."' AND '".$to;
        $reports['income']['total'] = money(Database::table('income')->where("user", $user->id)->where('income_date','BETWEEN',$range)->sum("amount", "total")[0]->total);
        $reports['expenses']['total'] = money(Database::table('expenses')->where("user", $user->id)->where('expense_date','BETWEEN',$range)->sum("amount", "total")[0]->total);
        $reports['income']['count'] = Database::table('income')->where("user", $user->id)->where('income_date','BETWEEN',$range)->count("amount", "total")[0]->total;
        $reports['expenses']['count'] = Database::table('expenses')->where("user", $user->id)->where('expense_date','BETWEEN',$range)->count("amount", "total")[0]->total;
        $reports['expenses']['top'] = Database::table('expenses')->where("user", $user->id)->where('expense_date','BETWEEN',$range)->orderBy("amount", false)->get();
        $reports['incomes'] = Database::table('income')->where("user", $user->id)->where('income_date','BETWEEN',$range)->orderBy("amount", false)->get();
        $reports['incomes']['top'] = Database::table('income')->where("user", $user->id)->where('income_date','BETWEEN',$range)->orderBy("amount", false)->get();
        
        if (!empty($reports['incomes']['top'])){
            foreach($reports['incomes']['top'] as $topIncome){
                $topIncome->amount = money($topIncome->amount);
            }
        }

       

        
 
        $begin = new \DateTime($from);
        $end = new \DateTime($to);
        $interval = new \DateInterval('P1D');
        $daterange = new \DatePeriod($begin, $interval ,$end);
        foreach ( $daterange as $dt ){
            $range = $dt->format( "Y-m-d" )." 00:00:00' AND '".$dt->format( "Y-m-d" )." 23:59:59";
            $reports['chart']['label'][] = $dt->format( "d F" );
            $reports['chart']['income'][] = Database::table('income')->where("user", $user->id)->where('income_date','BETWEEN',$range)->sum("amount", "total")[0]->total;
            $reports['chart']['expenses'][] = (Database::table('expenses')->where("user", $user->id)->where('expense_date','BETWEEN',$range)->sum("amount", "total")[0]->total * -1);
        }

        return $reports;
    }

    /**
     * Get Report
     * 
     * @return array
     */
    public function getreports(){
        $reports = self::reports(input("from").' 00:00:00', input("to").' 23:59:59');
        return response()->json(responder("success", "", "", "reports(".json_encode($reports).")", false));
    }


}
