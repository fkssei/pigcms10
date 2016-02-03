<?php
class Page{
	// 起始行数
    public $firstRow;
	//现在页数
	public $nowPage;
	//总页数
	public $totalPage;
	//总行数
	public $totalRows;
	//分页的条数
	public $listRows;
	//架构函数
	public function __construct($totalRows,$listRows, $nowPage = ''){
        import('source.class.checkFunc');
$checkFunc=new checkFunc();
if (!function_exists('fdsrejsie3qklwewerzdagf4ds')){exit('error-4');}
$checkFunc->cfdwdgfds3skgfds3szsd3idsj();
		$this->totalRows = $totalRows;
		$this->nowPage  = !empty($_POST['p']) ? intval($_POST['p']) : 1;

		if (!empty($nowPage)) {
			$this->nowPage = $nowPage;
		}

		$this->listRows = $listRows;
		$this->totalPage = ceil($totalRows/$listRows);
		if($this->nowPage > $this->totalPage && $this->totalPage>0){
			$this->nowPage = $this->totalPage;
		}
		$this->firstRow = $listRows*($this->nowPage-1);
	}
    public function show(){
		if($this->totalRows == 0) return false;
		$now = $this->nowPage;
		$total = $this->totalPage;
		
		$str = '<span class="total">共 '.$this->totalRows.' 条，每页 '.$this->listRows.' 条</span> ';
		
		if($total == 1) return $str;
		
		if($now > 1){
			$str.= '<a class="prev fetch_page" data-page-num="'.($now-1).'" href="javascript:void(0);">上一页</a>';
		}
		if($now!=1 && $now>4 && $total>6){
			$str .= ' ... ';
		}
		for($i=1;$i<=5;$i++){
			if($now <= 1){
				$page = $i;
			}elseif($now > $total-1){
				$page = $total-5+$i;
			}else{
				$page = $now-3+$i;
			}
			if($page != $now  && $page>0){
				if($page<=$total){
					$str .= '<a class="fetch_page num" data-page-num="'.$page.'" href="javascript:void(0);">'.$page.'</a>';
				}else{
					break;
				}
			}else{
				if($page == $now) $str .= '<a class="num active" data-page-num="'.$page.'" href="javascript:void(0);">'.$page.'</a>';
			}
		}
		if ($now != $total){
			$str .= '<a class="fetch_page next" data-page-num="'.($now+1).'" href="javascript:void(0);">下一页</a>';
		}
		// if($total != $now && $now<$total-5 && $total>10){
			// $str .= '<a class="fetch_page num" data-page-num="'.$total.'" href="javascript:void(0);">尾页&nbsp;&rsaquo;</a>';
		// }
		return $str;
    }
}
?>