<?php

class DefaultController extends BizpermitModuleController {

    public function actionIndex($section=FALSE,$data,$return=FALSE)
    {
    	$this->pageTitle ="Business Permits :".$data['section-title']." Manager";
   		return $this->render($section,$data,$return);       
    }

   	public function actionGrid($entity=FALSE)
	{	
		$model=isset($_GET['entity'])?$_GET['entity']:'';
		$id=isset($_GET['id'])?$_GET['id']:FALSE;
		$return=isset($_GET['return'])?$_GET['return']:FALSE;
		$grid=$this->grids($model);
		$form=$model;
		$model=new $model;
		$attributes=$model->attributes;
		$data['section-title']=$grid['title'];
		$data['fields']=array_keys($attributes);
		$data['ex_fields']=$grid['ex_fields'];
		$data['primary']=$grid['primary'];
		$data['buttons']=$grid['buttons'];
		$data['action_new']=(isset($grid['action_new']))?$grid['action_new']:TRUE;
		if(isset($grid['foreign_keys']))
		{
			$data['foreign_keys']=$grid['foreign_keys'];
		}
		$data['search_fields']=$this->_fields($data['fields'],$data['ex_fields']);		
		$conditions=array($data['fields'][0]=>$id);
		$data['entity']=$form;
		if(isset($grid['joins']))
		{
			$joins=$grid['joins'];
		}
		else
		{
			$joins='';
		}
		if($id!=FALSE)
		{
			$data['results']=$this->fetch($form,array('fields'=>implode(",",$data['search_fields']),'conditions'=>$conditions,'joins'=>$joins));			
		}
		else
		{
			$data['results']=$this->fetch($form,array('fields'=>implode(",",$data['search_fields']),'joins'=>$joins));
		
		}
		$this->actionIndex('sections/grid',$data,$return);
		//return $this->render('sections/grid',$data,$return);
	}

	private function _fields($fields,$ex_fields)
	{
		foreach ($fields as $value)
		{
			if(!in_array($value,$ex_fields))
			{
				$data['search_fields'][$value]=$value;
			}
		}
		return $data['search_fields'];
	}


	public function actionSection()
	{
		$section=$_GET['entity'];
		$this->render('sections/'.$section);
	}

	/**Displays a bill**/
	public function actionBill()
	{
		//die('called');
		$params=$_GET;
		$entity=$params['entity'];
		$bill_id=$params['id'];
		$conditions=array('bill_id'=>$bill_id);
		$joins=array('business'=>'LEFT JOIN `bpt_business` AS u ON t.bill_business_id =u.business_id');			
		$data['bill']=$this->fetch($entity,array('fields'=>'bill_id,bill_business_id,bill_status','conditions'=>$conditions,'joins'=>$joins));
		$conditions=array('bill_item_ref'=>$bill_id);	//$joins=array('business'=>'LEFT JOIN `bpt_business` AS u ON t.business_id =u.business_id','bill_item'=>'RIGHT JOIN `bpt_bill_item` AS z ON t.bill_id =z.bill_id');			
		$data['bill_items']=$this->fetch('BillItem',array('fields'=>'bill_item_ref,bill_item_id,bill_item_amount,bill_item,bill_item_description','conditions'=>$conditions));
		//$data['business_det']=$this->fetch($entity,array('fields'=>'bill_id,business_id,bill_amount,bill_status','conditions'=>$conditions));
		//var_dump($data['bill_items']);
		$this->renderPartial('sections/bill',$data);
	}

	/**Receive payment for a bill**/
	public function actionPay()
	{
		$form=$_GET['entity'];
		//var_dump($_GET);die();
		$bill_id=$_GET['id'];
		$forms['title']='Pay Bill';
		$data['bill_id']=$bill_id;
		$id='';
		//$data['id']=$_GET['id'];
		$conditions=array('bill_item_ref'=>$bill_id);	//$joins=array('business'=>'LEFT JOIN `bpt_business` AS u ON t.business_id =u.business_id','bill_item'=>'RIGHT JOIN `bpt_bill_item` AS z ON t.bill_id =z.bill_id');			
		$data['bill_items']=$this->fetch('BillItem',array('fields'=>'bill_item_ref,bill_item_id,bill_item_amount,bill_item,bill_item_description','conditions'=>$conditions));
		$js=$this->renderPartial('snippets/saveJS',array('model'=>'Payment','id'=>$id),TRUE);
		$data['frmFoot']=$this->renderPartial('snippets/frmFoot','',TRUE);
		$data['frmHead']=$this->renderPartial('snippets/frmHead',array('title'=>$forms['title'],'js'=>$js),TRUE);		
		$this->renderPartial('forms/payment',$data);
	}

	/**Loads a form**/
	public function actionForm()
	{
		
		$params=$_GET;
		$form=$params['entity'];
		$forms=$this->forms($form);
		$model=$form;
		$model=new $model;
		$attributes=$model->attributes;
		//var_dump($attributes);die();
		$fields=array_keys($attributes);
		$ex_fields=$forms['ex_fields'];
		$primary=$forms['primary'];
		$search_fields=$this->_fields($fields,$ex_fields);
		$data=$this->loadParams($forms['params']);
		if(isset($forms['joins']))
		{
			$joins=$forms['joins'];
		}
		else
		{
			$joins='';
		}
		if(isset($_GET['id']))
		{
			$id=$_GET['id'];
			$forms['title']="Edit ".$forms['title'];			
			$conditions=array($primary=>$id);
			$values_det=$this->fetch($form,array('conditions'=>$conditions,'joins'=>$joins,'fields'=>implode(',',$search_fields)));
			//var_dump($values_det);die();
			foreach($values_det as $f_val)
			{
				$data['values_det']=$f_val;		
			}
		}
		else
		{
			$id="";
			$forms['title']="New ".$forms['title'];
			foreach($fields as $f)
			{
				$data['values_det'][$f]="";
			}			
		}
		$js=$this->renderPartial('snippets/saveJS',array('model'=>$form,'id'=>$id),TRUE);
		$data['frmFoot']=$this->renderPartial('snippets/frmFoot','',TRUE);
		$data['frmHead']=$this->renderPartial('snippets/frmHead',array('title'=>$forms['title'],'js'=>$js),TRUE);
		
		$data['id']=$id;
		$data['model']=$form;
		$this->renderPartial('forms/'.$form,$data);		
	}

	/**Loads a complete models with all data.These are the parameters as specified in the forms and grid array**/
	public function loadParams($params)
	{
		foreach($params as $param_k=>$param_v)
		{
			$data[$param_k]=$this->fetch($param_k,array('fields'=>$param_v['fields']));						
		}	
		return $data;
	}


	/**Fetches data from a model.
	*@param $model <model name>
	*@param $options <array of criteria>
	**/
	function fetch($model,$options=FALSE)
	{
		$options['fields']=explode(',',$options['fields']);
		$criteria=new CDbCriteria;

		if(!empty($options['fields']))
		{
			$criteria->select=$options['fields'];
		}
		if(!empty($options['conditions']))
		{
			foreach($options['conditions'] as $k=>$v)		
			{
				$criteria->condition=$k.'=:val_'.$k;
				$criteria->params=array(':val_'.$k=>$v);
			}
		}
		if(!empty($options['joins']))
		{
			foreach($options['joins'] as $join_k=>$join_v)
			{
				$criteria->with = $join_k;            	
			}
		}	
		
		$model=call_user_func_array(array($model,'model'),array());
		return $data['results']=call_user_func_array(array($model,'findAll'),array($criteria));

	}

	/**Used to save and update records**/
	public function actionSave()
	{
		$form=$model=$_POST['model'];
		unset($_POST['model']);
		unset($_POST['q']);
		if(isset($_POST['id']))
		{
			$id=$_POST['id'];
			unset($_POST['id']);
			$model=call_user_func_array(array($model,'model'),array());
			$model=call_user_func_array(array($model,'findByPk'),array($id));			
		}
		else
		{
			$model=new $model;
		}
		//$model->attributes=$_POST;
		$model->setAttributes( $_POST);
		//var_dump($model->attributes);die();
		$model->validate();
		if (!$model->hasErrors())
		{
			if($model->save())
			{
				$attributes=$model->attributes;
				$fields=array_keys($attributes);
				//var_dump($this->actionGrid($form,$fields[0],TRUE));
				echo json_encode(array('info'=>'success','success'=>$form." successfully saved"));				
			}			
		}
		else
		{
			//var_dump($model->getErrors());
			echo json_encode(array('info'=>'invalid','errors'=>$model->getErrors()));	
			//echo json_encode($model->getErrors());
		}
	}

	public function actionDelete()
	{
		$form=$model=$_GET['entity'];
		if(isset($_GET['id']))
		{
			$id=$_GET['id'];
			unset($_POST['id']);
			$model=call_user_func_array(array($model,'model'),array());
			$model=call_user_func_array(array($model,'findByPk'),array($id));			
		}
		$model->attributes=array('status'=>0);
		if($model->save())
		{
			echo json_encode(array('info'=>'success'));
		}
	}

	
	public function sections($section)
	{
		$sections=array(
			'dashboard'=>array('forms'=>array(''),'grids'=>array(''),'charts'=>array(''),'views'=>array('')),
			'grid'=>array('grids'=>array('default')),
			'bill'=>array('title'=>'BILLS'),
			'permits'=>array('title'=>'Permits')
			);
		return $sections[$section];	
	}

	
	/*USED TO SETUP ALL FORMS.
	*@param $form is the form that will be loaded
	*Each form-name is linked to a model.
	*ex-fields specifies the fields to exclude.
	*params specifies an extra model data to load with the form,plus the fields to get from it
	*primary_key is just that
	*foreign_keys is an array of all foreign keys in the form.Each of this starts with ther foreign key as the key of the array,the model name as the first element and which field in this model should be displayed in place of the foreign key field
	**/
	public function forms($form)
	{
		$forms=array(
			'feeSchedule'=>array('ex_fields'=>array('created_at','updated_at','status'),'title'=>'Fee Schedule','primary'=>'schedule_id',
								'params'=>array('Zone'=>array('fields'=>'zone_id,zone_name'),'councilSchedule'=>array('fields'=>'cl_schedule_id,schedule_no,gazette_date'),'scheduleCategory'=>array('fields'=>'category_id,category_code,category_name'))),
			'penaltyRate'=>array('ex_fields'=>array('created_at','updated_at','status'),'title'=>'Penalty Rate','primary'=>'penalty_id',
								'params'=>array('feeSchedule'=>array('fields'=>'schedule_id,schedule_name'))),
			'Business'=>array('ex_fields'=>array('created_at','updated_at','status'),'title'=>'Business','primary'=>'business_id',
								'params'=>array('Zone'=>array('fields'=>'zone_id,zone_name'),'Ward'=>array('fields'=>'ward_id,ward_name'),'feeSchedule'=>array('fields'=>'schedule_id,schedule_name,brims_code,sbp_fee'))),
			'Ward'=>array('ex_fields'=>array('created_at','updated_at','status'),'title'=>'Ward','primary'=>'ward_id',
								'params'=>array('Zone'=>array('fields'=>'zone_id,zone_name'))),
			'Zone'=>array('ex_fields'=>array('created_at','updated_at','status'),'title'=>'Zone','primary'=>'zone_id',
								'params'=>array('Zone'=>array('fields'=>'zone_id,zone_name'))),
			'scheduleCategory'=>array('ex_fields'=>array('created_at','updated_at','status'),'title'=>'Fee Schedule Categories','primary'=>'category_id',
								'params'=>array('Zone'=>array('fields'=>'zone_id,zone_name'))),
			'councilSchedule'=>array('ex_fields'=>array('created_at','updated_at','status'),'title'=>'Council Schedule','primary'=>'cl_schedule_id','params'=>array('Zone'=>array('fields'=>'zone_id,zone_name'))),
			);
		return $forms[$form];
	}

	/*USED TO SETUP ALL GRIDS.
	*@param $form is the form that will be loaded
	*Each grid-name is linked to a model.
	*ex-fields specifies the fields to exclude.
	*params specifies an extra model data to load with the form,plus the fields to get from it
	*primary_key is just that
	*foreign_keys is an array of all foreign keys in the form.Each of this starts with ther foreign key as the key of the array,the model name as the first element and which field in this model should be displayed in place of the foreign key field
	**/
	public function grids($grid)
	{
		$grids=array(
			'feeSchedule'=>array('ex_fields'=>array('created_at','updated_at','status'),'primary'=>'schedule_id','buttons'=>array('delete'=>array('Delete','default/delete','icon-trash'),'Edit'=>array('Edit','default/form','icon-edit')),'title'=>'Fee Schedule'),
			'councilSchedule'=>array('ex_fields'=>array('created_at','updated_at','status'),'primary'=>'cl_schedule_id','buttons'=>array('delete'=>array('Delete','default/delete','icon-trash'),'Edit'=>array('Edit','default/form','icon-edit')),'title'=>'Council Schedule'),
			'Business'=>array('title'=>'Business','ex_fields'=>array('created_at','updated_at','status','user_id','doc_type','doc_no','employees','pin_no','vat_no','bs_tel_no1','bs_tel_no2','bs_fax_no','plot_no','plot_designation','ct_fax_no','ct_box_no','ct_postal_code','bs_box_no','bs_postal_code','area','activity_desc','other_details','activity_code','relative_size','bs_town','physical_address','ct_designation','created_at'),'primary'=>'business_id','buttons'=>array('delete'=>array('Delete','default/delete','icon-trash'),'Edit'=>array('Edit','default/form','icon-edit'))),
			'penaltyRate'=>array('title'=>'Penalty Rate','ex_fields'=>array('created_at','updated_at','status'),'primary'=>'penalty_id','buttons'=>array('delete'=>array('Delete','default/delete','icon-trash'),'Edit'=>array('Edit','default/form','icon-edit'))),
			'Ward'=>array('title'=>'Ward','ex_fields'=>array('created_at','updated_at','status'),'primary'=>'ward_id','buttons'=>array('delete'=>array('Delete','default/delete','icon-trash'),'Edit'=>array('Edit','default/form','icon-edit'))),
			'Zone'=>array('title'=>'Zone','ex_fields'=>array('created_at','updated_at','status'),'primary'=>'zone_id','buttons'=>array('delete'=>array('Delete','default/delete','icon-trash'),'Edit'=>array('Edit','default/form','icon-edit'))),
			'scheduleCategory'=>array('title'=>'Fee Schedule Categories','ex_fields'=>array('created_at','updated_at','status'),'primary'=>'category_id','buttons'=>array('delete'=>array('Delete','default/delete','icon-trash'),'Edit'=>array('Edit','default/form','icon-edit'))),
			'Bill'=>array('title'=>'Bill','ex_fields'=>array('created_at','updated_at'),'primary'=>'bill_id','foreign_keys'=>array('business_id'=>array('business','business_name')),'action_new'=>FALSE,'buttons'=>array('bill'=>array('View Bill','default/bill','icon-trash'),'pay'=>array('Pay Bill','default/pay','icon-edit')),'joins'=>array('business'=>array('join'=>'LEFT JOIN `bpt_business` AS u ON t.business_id =u.business_id','ex_fields'=>array('created_at','updated_at'))))
		);
		return $grids[$grid];
	}

	public function views($view)
	{
		$views=array(
			'feeSchedule'=>array('fields'=>array(),
								'params'=>array('Zones'=>array('fields'=>''))),
			);
		return $forms[$form];
	}       


}
