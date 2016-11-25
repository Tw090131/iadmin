<?php
namespace App\Repositories\Presenter;

class MenuPresenter
{

	public function getMenu($menus)
	{
		if ($menus) {
			$option = '<option value="0">顶级菜单</option>';
			foreach ($menus as $v) {
				$option .= '<option value="'.$v->id.'">'.$v->name.'</option>';
			}
			return $option;
		}
		return '<option value="0">顶级菜单</option>';
	}

	/**
	 * 菜单列表视图

	 */
	public function getMenuList($menus)
	{
		if ($menus) {
			$item = '';
			foreach ($menus as $v) {
				$item.= $this->getNestableItem($v);
			}
			return $item;
		}
		return '暂无菜单';
	}

	/**
	 * 返回菜单HTML代码

	 */
	protected function getNestableItem($menu)
	{
		if ($menu['child']) {
			return $this->getHandleList($menu['id'],$menu['name'],$menu['child']);
		}
		if ($menu['parent_id'] == 0) {
			return '<li class="dd-item dd3-item" data-id="'.$menu['id'].'"><div class="dd-handle dd3-handle"> </div><div class="dd3-content"> '.$menu['name'].$this->getActionButtons($menu['id']).' </div></li>';
		}
		return '<li class="dd-item dd3-item" data-id="'.$menu['id'].'"><div class="dd-handle dd3-handle"> </div><div class="dd3-content"> '.$menu['name'].$this->getActionButtons($menu['id'],false).' </div></li>';
	}

	/**
	 * 判断是否有子集

	 */
	protected function getHandleList($id,$name,$child)
	{
		$handle = '<li class="dd-item dd3-item" data-id="'.$id.'"><div class="dd-handle dd3-handle"> </div><div class="dd3-content"> '.$name.$this->getActionButtons($id).' </div><ol class="dd-list">';
		if ($child) {
			foreach ($child as $v) {
				$handle .= $this->getNestableItem($v);
			}
		}
		$handle .= '</ol></li>';
		return $handle;
	}
	/**
	 * 菜单按钮

	 */
	protected function getActionButtons($id,$bool = true)
	{
		$action = '<div class="pull-right action-buttons">';
		if (auth()->user()->can(config('admin.permissions.menus.add')) && $bool) {
			$action .= '<a href="javascript:;" data-pid="'.$id.'" class="btn-xs createMenu" data-toggle="tooltip"data-original-title="添加"  data-placement="top"><i class="fa fa-plus"></i></a>';
		}

		if (auth()->user()->can(config('admin.permissions.menus.edit'))) {
			$action .= '<a href="javascript:;" data-href="'.url('admin/menus/'.$id.'/edit').'" class="btn-xs editMenu" data-toggle="tooltip"data-original-title="修改"  data-placement="top"><i class="fa fa-pencil"></i></a>';
		}

		if (auth()->user()->can(config('admin.permissions.menus.delete'))) {
			$action .= '<a href="javascript:;" class="btn-xs destoryMenu" data-id="'.$id.'" data-original-title="删除"data-toggle="tooltip"  data-placement="top"><i class="fa fa-trash"></i><form action="'.url('admin/menus',[$id]).'" method="POST" name="delete_item'.$id.'" style="display:none"><input type="hidden"name="_method" value="delete"><input type="hidden" name="_token" value="'.csrf_token().'"></form></a>';
		}
		$action .= '</div>';
		return $action;
	}

	/**
	 * 左侧菜单渲染

	 */
	public function sidebarMenus($menus)
	{

		$html = '';
		if ($menus) {
			$html = '<li>';
			foreach ($menus as $v) {
				//dump($v);
			//	dump(auth()->user()->can($v['slug']));
				if (auth()->user()->can($v['slug'])) {
					if ($v['child']) {
					//	dump($v['heightlight_url']);
						$html .= '<li class="'.active_class(if_uri_pattern(explode(',',$v['heightlight_url']))).'"><a><i class="'.$v['icon'].'"></i> '.$v['name'].' <span class="fa fa-chevron-down"></span></a>'.$this->getSidebarChildMenu($v['child'],$v['heightlight_url']).'</li>';
					}else{
						$html .= '<li class="'.active_class(if_uri_pattern([$v['heightlight_url']])).'"><a href="'.$v['url'].'"><i class="'.$v['icon'].'"></i> '.$v['name'].'</a></li>';
					}
				}
			}
			$html .= '</li>';
		}
		return $html;
	}
	/**
	 * 左侧菜单子菜单渲染

	 */
	public function getSidebarChildMenu($childMenu='',$height_url)
	{
		$query_string= empty($_SERVER["QUERY_STRING"])?'':'?'.$_SERVER["QUERY_STRING"];
		$html = '';
		if ($childMenu) {
//			dump($childMenu);
//			dump(if_uri_pattern(['admin/system*']));
			//dd(active_class(false));  true 返回active  false 返回“”
			$html = '<ul class="nav child_menu" style="display:'.active_class(if_uri_pattern([$height_url.'*']),'block','none').'">';
			foreach ($childMenu as $v) {
//				$str = $v['heightlight_url'];
//				dump($str);
////				dump(if_uri_pattern([$v['heightlight_url']]));
//				dump($v['heightlight_url'].$this->_isAddQuery($query_string,$v['slug']));
//				dump(if_uri_pattern([$v['heightlight_url'].'*']));
				if (auth()->user()->can($v['slug'])) {
				//	$html .= '<li class="'.active_class(if_query([$v['heightlight_url']]),'current-page').'"><a href="'.url($v['url']).$this->_isAddQuery($query_string,$v['slug']).'">'.$v['name'].'</a></li>';
					$html .= '<li class="'.active_class(if_uri_pattern([$v['heightlight_url'].'*']),'current-page').'"><a href="'.url($v['url']).$this->_isAddQuery($query_string,$v['slug']).'">'.$v['name'].'</a></li>';
				}
			}
			$html .= '</ul>';
		}
		return $html;
	}

	//判断是否要加参数
	private function _isAddQuery($query_str,$slug){
		//dump($slug);
		$arr = explode('.',$slug);
		if(!config('admin.permissions.'.$arr[1].'.setappid')){
			$query_str='';
		}
		return $query_str;
	}
}