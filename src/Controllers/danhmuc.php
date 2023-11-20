<?php
namespace Simcify\Controllers;

use Simcify\File;
use Simcify\Auth;
use Simcify\Database;
use DotEnvWriter\DotEnvWriter;

class danhmuc {
    
    /**
     * Get settings view
     * 
     * @return \Pecee\Http\Response
     */
    public function get() {
        $title      = __('pages.profile-menu.settings');
        $user       = Auth::user();
        $timezones  = Database::table("timezones")->get();
        $currencies = Database::table("currencies")->get();
        $accounts = Database::table('accounts')->where('user', $user->id)->orderBy("id", false)->get();
        $categories = Database::table('categories')->where('user',$user->id)->orderBy("name", true)->get();
        return view('danhmuc', compact("user", "title", "timezones", "currencies","accounts","categories"));
    }
    
    
    /**
     * Add category
     * 
     * @return Json
     */
    public function addcategory() {
        $data = array(
            'name' => input('category'),
            'type' => input('type'),
            'user' => Auth::user()->id
        );
        Database::table('categories')->insert($data);
        return response()->json(responder("success", __('pages.messages.alright'), __('settings.messages.category-add-success'), "reload()"));
    }
    
    
    /**
     * Category message
     * 
     * @return Json
     */
    public function deletecategory() {
        Database::table("categories")->where("id", input("categoryid"))->delete();
        return response()->json(responder("success", __('settings.messages.category-deleted'), __('settings.messages.category-delete-success'), "reload()"));
    }
    
    /**
     * Update category view
     * 
     * @return Json
     */
    public function updatecategoryview() {
        $category = Database::table('categories')->where('id', input("categoryid"))->first();
        return view('includes/ajax/editcategory', compact("category"));
    }
    
    /**
     * Update category
     * 
     * @return Json
     */
    public function updatecategory() {
        $data = array(
            'name' => input('category'),
            'type' => input('type')
        );
        Database::table('categories')->where('id', input("categoryid"))->update($data);
        return response()->json(responder("success", __('pages.messages.alright'), __('settings.messages.category-edit-success'), "reload()"));
    }
    
}