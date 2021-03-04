<?php
/**
 * Controller genrated using LaraAdmin
 * Help: http://laraadmin.com
 */

namespace App\Http\Controllers\LA;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests;
use Auth;
use DB;
use Validator;
use Datatables;
use Collective\Html\FormFacade as Form;
use Dwij\Laraadmin\Models\Module;
use Dwij\Laraadmin\Models\ModuleFields;

use App\Models\TICKETS_CAJEME;

class TICKETS_CAJEMESController extends Controller
{
	public $show_action = true;
	public $view_col = 'correoinstitucional';
	public $listing_cols = ['id', 'correoinstitucional', 'foto', 'validado'];
	
	public function __construct() {
		// Field Access of Listing Columns
		if(\Dwij\Laraadmin\Helpers\LAHelper::laravel_ver() == 5.3) {
			$this->middleware(function ($request, $next) {
				$this->listing_cols = ModuleFields::listingColumnAccessScan('TICKETS_CAJEMES', $this->listing_cols);
				return $next($request);
			});
		} else {
			$this->listing_cols = ModuleFields::listingColumnAccessScan('TICKETS_CAJEMES', $this->listing_cols);
		}
	}
	
	/**
	 * Display a listing of the TICKETS_CAJEMES.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		$module = Module::get('TICKETS_CAJEMES');
		
		if(Module::hasAccess($module->id)) {
			return View('la.tickets_cajemes.index', [
				'show_actions' => $this->show_action,
				'listing_cols' => $this->listing_cols,
				'module' => $module
			]);
		} else {
            return redirect(config('laraadmin.adminRoute')."/");
        }
	}

	/**
	 * Show the form for creating a new tickets_cajeme.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created tickets_cajeme in database.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request)
	{
		if(Module::hasAccess("TICKETS_CAJEMES", "create")) {
		
			$rules = Module::validateRules("TICKETS_CAJEMES", $request);
			
			$validator = Validator::make($request->all(), $rules);
			
			if ($validator->fails()) {
				return redirect()->back()->withErrors($validator)->withInput();
			}
			
			$insert_id = Module::insert("TICKETS_CAJEMES", $request);
			
			return redirect()->route(config('laraadmin.adminRoute') . '.tickets_cajemes.index');
			
		} else {
			return redirect(config('laraadmin.adminRoute')."/");
		}
	}

	/**
	 * Display the specified tickets_cajeme.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function show($id)
	{
		if(Module::hasAccess("TICKETS_CAJEMES", "view")) {
			
			$tickets_cajeme = TICKETS_CAJEME::find($id);
			if(isset($tickets_cajeme->id)) {
				$module = Module::get('TICKETS_CAJEMES');
				$module->row = $tickets_cajeme;
				
				return view('la.tickets_cajemes.show', [
					'module' => $module,
					'view_col' => $this->view_col,
					'no_header' => true,
					'no_padding' => "no-padding"
				])->with('tickets_cajeme', $tickets_cajeme);
			} else {
				return view('errors.404', [
					'record_id' => $id,
					'record_name' => ucfirst("tickets_cajeme"),
				]);
			}
		} else {
			return redirect(config('laraadmin.adminRoute')."/");
		}
	}

	/**
	 * Show the form for editing the specified tickets_cajeme.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function edit($id)
	{
		if(Module::hasAccess("TICKETS_CAJEMES", "edit")) {			
			$tickets_cajeme = TICKETS_CAJEME::find($id);
			if(isset($tickets_cajeme->id)) {	
				$module = Module::get('TICKETS_CAJEMES');
				
				$module->row = $tickets_cajeme;
				
				return view('la.tickets_cajemes.edit', [
					'module' => $module,
					'view_col' => $this->view_col,
				])->with('tickets_cajeme', $tickets_cajeme);
			} else {
				return view('errors.404', [
					'record_id' => $id,
					'record_name' => ucfirst("tickets_cajeme"),
				]);
			}
		} else {
			return redirect(config('laraadmin.adminRoute')."/");
		}
	}

	/**
	 * Update the specified tickets_cajeme in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, $id)
	{
		if(Module::hasAccess("TICKETS_CAJEMES", "edit")) {
			
			$rules = Module::validateRules("TICKETS_CAJEMES", $request, true);
			
			$validator = Validator::make($request->all(), $rules);
			
			if ($validator->fails()) {
				return redirect()->back()->withErrors($validator)->withInput();;
			}
			
			$insert_id = Module::updateRow("TICKETS_CAJEMES", $request, $id);
			
			return redirect()->route(config('laraadmin.adminRoute') . '.tickets_cajemes.index');
			
		} else {
			return redirect(config('laraadmin.adminRoute')."/");
		}
	}

	/**
	 * Remove the specified tickets_cajeme from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id)
	{
		if(Module::hasAccess("TICKETS_CAJEMES", "delete")) {
			TICKETS_CAJEME::find($id)->delete();
			
			// Redirecting to index() method
			return redirect()->route(config('laraadmin.adminRoute') . '.tickets_cajemes.index');
		} else {
			return redirect(config('laraadmin.adminRoute')."/");
		}
	}
	
	/**
	 * Datatable Ajax fetch
	 *
	 * @return
	 */
	public function dtajax()
	{
		$values = DB::table('tickets_cajemes')->select($this->listing_cols)->whereNull('deleted_at');
		$out = Datatables::of($values)->make();
		$data = $out->getData();

		$fields_popup = ModuleFields::getModuleFields('TICKETS_CAJEMES');
		
		for($i=0; $i < count($data->data); $i++) {
			for ($j=0; $j < count($this->listing_cols); $j++) { 
				$col = $this->listing_cols[$j];
				if($fields_popup[$col] != null && starts_with($fields_popup[$col]->popup_vals, "@")) {
					$data->data[$i][$j] = ModuleFields::getFieldValue($fields_popup[$col], $data->data[$i][$j]);
				}
				if($col == $this->view_col) {
					$data->data[$i][$j] = '<a href="'.url(config('laraadmin.adminRoute') . '/tickets_cajemes/'.$data->data[$i][0]).'">'.$data->data[$i][$j].'</a>';
				}
				// else if($col == "author") {
				//    $data->data[$i][$j];
				// }
			}
			
			if($this->show_action) {
				$output = '';
				if(Module::hasAccess("TICKETS_CAJEMES", "edit")) {
					$output .= '<a href="'.url(config('laraadmin.adminRoute') . '/tickets_cajemes/'.$data->data[$i][0].'/edit').'" class="btn btn-warning btn-xs" style="display:inline;padding:2px 5px 3px 5px;"><i class="fa fa-edit"></i></a>';
				}
				
				if(Module::hasAccess("TICKETS_CAJEMES", "delete")) {
					$output .= Form::open(['route' => [config('laraadmin.adminRoute') . '.tickets_cajemes.destroy', $data->data[$i][0]], 'method' => 'delete', 'style'=>'display:inline']);
					$output .= ' <button class="btn btn-danger btn-xs" type="submit"><i class="fa fa-times"></i></button>';
					$output .= Form::close();
				}
				$data->data[$i][] = (string)$output;
			}
		}
		$out->setData($data);
		return $out;
	}
}
