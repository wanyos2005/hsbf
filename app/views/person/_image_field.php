<?php
$photo_src = MyYiiUtils::getThumbSrc($model->getProfileImagePath(), array('resize' => array('width' => 150, 'height' => 150)));
$preview_img_id = '_profile_image_preview';
$class_name = $model->getClassName();
$temp_selector = '#' . $class_name . '_temp_profile_image';
$notif_id = 'my_progress_notif_image';
?>
<?php echo CHtml::activeHiddenField($model, 'temp_profile_image') ?>
<div class="form-group">
        <?php echo CHtml::activeLabel($model, 'profile_image', array('class' => isset($htmlOptions['label_class']) ? $htmlOptions['label_class'] : 'col-md-2 control-label', 'label' => $model->getAttributeLabel('profile_image') . ':')); ?>
        <div class="<?php echo isset($htmlOptions['field_class']) ? $htmlOptions['field_class'] : 'col-md-4' ?>">
                <img id="<?php echo $preview_img_id ?>" class="thumbnail default-profile-photo" src="<?php echo $photo_src ?>" data-src="<?php echo $photo_src ?>">
                <div>
                        <?php
                        $input_name = Common::generateSalt();
                        $this->widget('ext.EAjaxUpload.EAjaxUpload', array(
                            'id' => 'uploadFile_' . $preview_img_id,
                            'config' => array(
                                'request' => array(
                                    'params' => array(
                                        'file_name' => $input_name,
                                    ),
                                    'endpoint' => Yii::app()->createUrl('myHelper/fineUploader'),
                                ),
                                'multiple' => FALSE,
                                'text' => array(
                                    'uploadButton' => 'Browse files or drop a file here',
                                ),
                                'deleteFile' => array(
                                    'enabled' => true,
                                    'method' => 'POST',
                                    'endpoint' => Yii::app()->createUrl('myHelper/deleteFineUploader'),
                                //'forceConfirm'=>true,
                                ),
                                'validation' => array(
                                    'itemLimit' => 1,
                                    'allowedExtensions' => array("jpg", "jpeg", "png"), //array("jpg","jpeg","gif","exe","mov" and etc...
                                    'sizeLimit' => 2 * 1024 * 1024, //2MB maximum file size in bytes
                                ),
                                'showMessage' => "js:function(message){
                                                MyUtils.showAlertMessage(message,'error','#" . $notif_id . "');
                                        }",
                                'callbacks' => array(
                                    'onComplete' => "js:function(id, fileName, responseJSON){
                                                if (responseJSON.success){
                                                                $('#" . $preview_img_id . "').attr('src',responseJSON.fileurl);
                                                                $('" . $temp_selector . "').val(responseJSON.filepath);
                                                        }
                                                }",
                                    'onDeleteComplete' => "js:function(id, xhr, isError){
                                                if(!isError){
                                                        var e=$('#" . $preview_img_id . "');
                                                        e.attr('src',e.attr('data-src'));
                                                        $('" . $temp_selector . "').val('');
                                                }
                                            }"
                                ),
                            )
                        ));
                        ?>
                        <div id="<?php echo $notif_id ?>"></div>
                </div>
        </div>
</div>