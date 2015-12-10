<?php

class Libs_Paginator{
	private $page;
	private $start;
	private $onPage;
	private $link;
	private $textPrev;
	private $textNext;
	private $pages;

	/**
	 * Libs_Paginator constructor.
	 * @param $page
	 * @param $start
	 * @param $onPage
	 */
	public function __construct($link, $page = 1, $onPage = 10){
		$link = preg_replace('/[\?\&]page=\d*/si', '', $link);
		$this->link = $link.(strpos($link, '?') === false ? '?' : '&').'page={#}';
		$this->page = $page;
		$this->start = $page * $onPage - 1;
		$this->onPage = $onPage;

		$this->textNext = '>';
		$this->textPrev = '<';
	}

	/**
	 * @return int
	 */
	public function getPage(){
		return $this->page;
	}

	/**
	 * @return int
	 */
	public function getStart(){
		return $this->start;
	}

	/**
	 * @return int
	 */
	public function getOnPage(){
		return $this->onPage;
	}

	/**
	 * @return mixed
	 */
	public function getLink(){
		return $this->link;
	}

	/**
	 * @param string $textPrev
	 */
	public function setTextPrev($textPrev){
		$this->textPrev = $textPrev;
	}

	/**
	 * @param string $textNext
	 */
	public function setTextNext($textNext){
		$this->textNext = $textNext;
	}

	/**
	 * @param mixed $pages
	 */
	public function setPages($pages){
		$this->pages = $pages;
	}

	public function getPagination(){
		return $this->pages > 7 ? $this->bigPagination() : $this->smallPagination();
	}

	private function smallPagination(){
		$html = '<div id="paginator" style="display: flex">';

		if ($this->page > 1){
			$link = str_replace('{#}', $this->page - 1, $this->link);
			$html .= '<a href="'.$link.'" class="paginator-btn back">'.$this->textPrev.'</a>';
		}
		for ($i = 1; $i <= $this->pages; $i++){
			$active = $this->page == $i ? ' active' : '';
			$link = str_replace('{#}', $i, $this->link);
			$html .= '<a href="'.$link.'" class="paginator-btn'.$active.'">'.$i.'</a>';
		}

		if ($this->pages > $this->page){
			$link = str_replace('{#}', $this->page + 1, $this->link);
			$html .= '<a href="'.$link.'" class="paginator-btn next">'.$this->textNext.'</a>';
		}
		$html .= '</div>';

		return $html;
	}

	private function bigPagination(){
		$html = '<div id="paginator" style="display: flex">';

		if ($this->page > 1){
			$link = str_replace('{#}', $this->page - 1, $this->link);
			$html .= '<a href="'.$link.'" class="paginator-btn back">'.$this->textPrev.'</a>';
		}

		$active = $this->page == 1 ? ' active' : '';
		$link = str_replace('{#}', 1, $this->link);
		$html .= '<a href="'.$link.'" class="paginator-btn'.$active.'">1</a>';

		if ($this->page > 4){
			$html .= '<div class="paginator-dots">...</div>';
		} else{
			$active = $this->page == 2 ? ' active' : '';
			$link = str_replace('{#}', 2, $this->link);
			$html .= '<a href="'.$link.'" class="paginator-btn'.$active.'">2</a>';
		}

		$count = 0;
		if ($this->page == $this->pages){
			$i = -4;
		} else if ($this->page == $this->pages - 1){
			$i = -3;
		} else if ($this->page == $this->pages - 2){
			$i = -2;
		} else{
			$i = -1;
		}
		while ($count < 3){
			$index = $this->page + $i;

			if ($index > 2 && $index < $this->pages - 1){
				$count++;

				$active = $this->page == $index ? ' active' : '';
				$link = str_replace('{#}', $index, $this->link);

				$html .= '<a href="'.$link.'" class="paginator-btn'.$active.'">'.$index.'</a>';
			}

			$i++;
		}

		if ($this->page < $this->pages - 3){
			$html .= '<div class="paginator-dots">...</div>';
		} else{
			$active = $this->page == ($this->pages - 1) ? ' active' : '';
			$link = str_replace('{#}', $this->pages - 1, $this->link);
			$html .= '<a href="'.$link.'" class="paginator-btn'.$active.'">'.($this->pages - 1).'</a>';
		}

		$active = $this->page == $this->pages ? ' active' : '';
		$link = str_replace('{#}', $this->pages, $this->link);
		$html .= '<a href="'.$link.'" class="paginator-btn'.$active.'">'.$this->pages.'</a>';

		if ($this->pages > $this->page){
			$link = str_replace('{#}', $this->page + 1, $this->link);
			$html .= '<a href="'.$link.'" class="paginator-btn next">'.$this->textNext.'</a>';
		}
		$html .= '</div>';

		return $html;
	}
}