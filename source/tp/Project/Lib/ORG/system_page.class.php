<?php
//狗扑源码社区 www.gope.cn
class Page
{
	public $firstRow;
	public $nowPage;
	public $totalPage;
	public $totalRows;
	public $page_rows;

	public function __construct($totalRows, $listRows)
	{
		$this->totalRows = $totalRows;
		$this->nowPage = !empty($_GET['page']) ? intval($_GET['page']) : 1;
		$this->listRows = $listRows;
		$this->totalPage = ceil($totalRows / $listRows);
		if (($this->totalPage < $this->nowPage) && (0 < $this->totalPage)) {
			$this->nowPage = $this->totalPage;
		}

		$this->firstRow = $listRows * ($this->nowPage - 1);
	}

	public function show()
	{
		if ($this->totalRows == 0) {
			return false;
		}

		$now = $this->nowPage;
		$total = $this->totalPage;
		$url = $_SERVER['REQUEST_URI'] . (strpos($_SERVER['REQUEST_URI'], '?') ? '' : '?');
		$parse = parse_url($url);

		if (isset($parse['query'])) {
			parse_str($parse['query'], $params);
			unset($params['page']);
			$url = $parse['path'] . '?' . http_build_query($params);
		}

		$url .= '&page=';
		$str = '<span class="total"><span id="row_count">' . $this->totalRows . '</span> 条记录 ' . $now . '/' . $total . '页</span>';

		if (1 < $now) {
			$str .= '<a href="' . $url . ($now - 1) . '" class="prev" title="上一页">上一页</a>';
		}

		if (($now != 1) && (4 < $now) && (6 < $total)) {
			$str .= '<a href="' . $url . '1" title="1">1</a><div class="page-numbers dots">…</div>';
		}

		for ($i = 1; $i <= 5; $i++) {
			if ($now <= 1) {
				$page = $i;
			}
			else if (($total - 1) < $now) {
				$page = ($total - 5) + $i;
			}
			else {
				$page = ($now - 3) + $i;
			}

			if (($page != $now) && (0 < $page)) {
				if ($page <= $total) {
					$str .= '<a href="' . $url . $page . '" title="第' . $page . '页">' . $page . '</a>';
				}
				else {
					break;
				}
			}
			else if ($page == $now) {
				$str .= '<span class="current">' . $page . '</span>';
			}
		}

		if (($total != $now) && ($now < ($total - 5)) && (10 < $total)) {
			$str .= '<span class="dots">…</span><a href="' . $url . $total . '" title="第' . $total . '页">' . $total . '</a>';
		}

		if ($now != $total) {
			$str .= '<a href="' . $url . ($now + 1) . '" class="next">下一页</a>';
		}

		return $str;
	}
}


?>
