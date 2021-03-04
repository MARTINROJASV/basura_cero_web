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

use App\Models\TICKETS_HERMOSILLO;

class TICKETS_HERMOSILLOSController extends Controller
{
	public $show_action = true;
	public $view_col = 'correoinstitucional';
	public $listing_cols = ['id', 'correoinstitucional', 'foto', 'validado'];
	
	public function __construct() {
		// Field Access of Listing Columns
		if(\Dwij\Laraadmin\Helpers\LAHelper::laravel_ver() == 5.3) {
			$this->middleware(function ($request, $next) {
				$this->listing_cols = ModuleFields::listingColumnAccessScan('TICKETS_HERMOSILLOS', $this->listing_cols);
				return $next($request);
			});
		} else {
			$this->listing_cols = ModuleFields::listingColumnAccessScan('TICKETS_HERMOSILLOS', $this->listing_cols);
		}
	}
	
	/**
	 * Display a listing of the TICKETS_HERMOSILLOS.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		$module = Module::get('TICKETS_HERMOSILLOS');
		
		if(Module::hasAccess($module->id)) {
			return View('la.tickets_hermosillos.index', [
				'show_actions' => $this->show_action,
				'listing_cols' => $this->listing_cols,
				'module' => $module
			]);
		} else {
            return redirect(config('laraadmin.adminRoute')."/");
        }
	}

	/**
	 * Show the form for creating a new tickets_hermosillo.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created tickets_hermosillo in database.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request)
	{
		if(Module::hasAccess("TICKETS_HERMOSILLOS", "create")) {
		
			$rules = Module::validateRules("TICKETS_HERMOSILLOS", $request);
			
			$validator = Validator::make($request->all(), $rules);
			
			if ($validator->fails()) {
				return redirect()->back()->withErrors($validator)->withInput();
			}
			
			$insert_id = Module::insert("TICKETS_HERMOSILLOS", $request);
			
			return redirect()->route(config('laraadmin.adminRoute') . '.tickets_hermosillos.index');
			
		} else {
			return redirect(config('laraadmin.adminRoute')."/");
		}
	}

	/**
	 * Display the specified tickets_hermosillo.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function show($id)
	{
		if(Module::hasAccess("TICKETS_HERMOSILLOS", "view")) {
			
			$tickets_hermosillo = TICKETS_HERMOSILLO::find($id);
			if(isset($tickets_hermosillo->id)) {
				$module = Module::get('TICKETS_HERMOSILLOS');
				$module->row = $tickets_hermosillo;
				
				return view('la.tickets_hermosillos.show', [
					'module' => $module,
					'view_col' => $this->view_col,
					'no_header' => true,
					'no_padding' => "no-padding"
				])->with('tickets_hermosillo', $tickets_hermosillo);
			} else {
				return view('errors.404', [
					'record_id' => $id,
					'record_name' => ucfirst("tickets_hermosillo"),
				]);
			}
		} else {
			return redirect(config('laraadmin.adminRoute')."/");
		}
	}

	/**
	 * Show the form for editing the specified tickets_hermosillo.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function edit($id)
	{
		if(Module::hasAccess("TICKETS_HERMOSILLOS", "edit")) {			
			$tickets_hermosillo = TICKETS_HERMOSILLO::find($id);
			if(isset($tickets_hermosillo->id)) {	
				$module = Module::get('TICKETS_HERMOSILLOS');
				
				$module->row = $tickets_hermosillo;
				
				return view('la.tickets_hermosillos.edit', [
					'module' => $module,
					'view_col' => $this->view_col,
				])->with('tickets_hermosillo', $tickets_hermosillo);
			} else {
				return view('errors.404', [
					'record_id' => $id,
					'record_name' => ucfirst("tickets_hermosillo"),
				]);
			}
		} else {
			return redirect(config('laraadmin.adminRoute')."/");
		}
	}

	/**
	 * Update the specified tickets_hermosillo in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, $id)
	{
		if(Module::hasAccess("TICKETS_HERMOSILLOS", "edit")) {
			
			$rules = Module::validateRules("TICKETS_HERMOSILLOS", $request, true);
			
			$validator = Validator::make($request->all(), $rules);
			
			if ($validator->fails()) {
				return redirect()->back()->withErrors($validator)->withInput();;
			}
			
			$insert_id = Module::updateRow("TICKETS_HERMOSILLOS", $request, $id);
			
			return redirect()->route(config('laraadmin.adminRoute') . '.tickets_hermosillos.index');
			
		} else {
			return redirect(config('laraadmin.adminRoute')."/");
		}
	}

	/**
	 * Remove the specified tickets_hermosillo from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id)
	{
		if(Module::hasAccess("TICKETS_HERMOSILLOS", "delete")) {
			TICKETS_HERMOSILLO::find($id)->delete();
			
			// Redirecting to index() method
			return redirect()->route(config('laraadmin.adminRoute') . '.tickets_hermosillos.index');
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
		$values = DB::table('tickets_hermosillos')->select($this->listing_cols)->whereNull('deleted_at');
		$out = Datatables::of($values)->make();
		$data = $out->getData();

		$fields_popup = ModuleFields::getModuleFields('TICKETS_HERMOSILLOS');
		
		for($i=0; $i < count($data->data); $i++) {
			for ($j=0; $j < count($this->listing_cols); $j++) { 
				$col = $this->listing_cols[$j];
				if($fields_popup[$col] != null && starts_with($fields_popup[$col]->popup_vals, "@")) {
					$data->data[$i][$j] = ModuleFields::getFieldValue($fields_popup[$col], $data->data[$i][$j]);
				}
				if($col == $this->view_col) {
					$data->data[$i][$j] = '<a href="'.url(config('laraadmin.adminRoute') . '/tickets_hermosillos/'.$data->data[$i][0]).'">'.$data->data[$i][$j].'</a>';
				}
				// else if($col == "author") {
				//    $data->data[$i][$j];
				// }
			}
			
			if($this->show_action) {
				$output = '';
				if(Module::hasAccess("TICKETS_HERMOSILLOS", "edit")) {
					$output .= '<a href="'.url(config('laraadmin.adminRoute') . '/tickets_hermosillos/'.$data->data[$i][0].'/edit').'" class="btn btn-warning btn-xs" style="display:inline;padding:2px 5px 3px 5px;"><i class="fa fa-edit"></i></a>';
				}
				
				if(Module::hasAccess("TICKETS_HERMOSILLOS", "delete")) {
					$output .= Form::open(['route' => [config('laraadmin.adminRoute') . '.tickets_hermosillos.destroy', $data->data[$i][0]], 'method' => 'delete', 'style'=>'display:inline']);
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
