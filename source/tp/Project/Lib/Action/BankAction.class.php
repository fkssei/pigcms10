<?php
/**
 * 收款银行
 * User: pigcms_21
 * Date: 2015/8/4
 * Time: 10:54
 */

class BankAction extends BaseAction
{
    public function index()
    {
        $bank = M('Bank');

        $bank_count = $bank->count('bank_id');
        import('@.ORG.system_page');
        $page = new Page($bank_count, 20);
        $banks = $bank->order('`bank_id` DESC')->limit($page->firstRow, $page->listRows)->select();
        $this->assign('banks',$banks);
        $this->assign('page', $page->show());

        $this->display();
    }

    public function add(){
        $this->assign('bg_color','#F3F3F3');
        $this->display();
    }

    public function edit(){
        $this->assign('bg_color','#F3F3F3');
        $database_bank = D('Bank');
        $condition_bank['bank_id'] = intval($_GET['id']);
        $bank = $database_bank->field(true)->where($condition_bank)->find();
        $this->assign('bank', $bank);
        $this->display();
    }

    public function modify(){
        if(IS_POST){
            $database_bank = D('Bank');
            if($database_bank->data($_POST)->add()){
                $this->success('添加成功！');
            }else{
                $this->error('添加失败！请重试~');
            }
        }else{
            $this->error('非法提交,请重新提交~');
        }
    }

    public function amend(){
        if(IS_POST){
            $database_bank = M('Bank');
            if($database_bank->data($_POST)->save()){
                $this->success('修改成功！');
            }else{
                $this->error('修改失败！请检查是否有过修改后重试~');
            }
        }else{
            $this->error('非法提交,请重新提交~');
        }
    }

    public function del(){
        if(IS_POST){
            $database_bank = D('Bank');
            $condition_bank['bank_id'] = intval($_POST['id']);
            if($database_bank->where($condition_bank)->delete()){
                S('bank_list',NULL);
                $this->success('删除成功！');
            }else{
                $this->error('删除失败！请重试~');
            }
        }else{
            $this->error('非法提交,请重新提交~');
        }
    }
} 