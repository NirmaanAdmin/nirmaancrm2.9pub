
<div class="modal _project_file" tabindex="-1" role="dialog" data-toggle="modal">
   <div class="modal-dialog modal-lg width-80" role="document">
      <div class="modal-content">
         <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
             <span aria-hidden="true">&times;</span>
           </button>
            <h4 class="modal-title">
                 <?php echo  $file->file_name; ?>

              </h4>
         </div>
         <div class="modal-body">
            <div class="row">
               <div class="col-md-12 border-right project_file_area">
                  
                  <?php

                     $path = TIMESHEETS_MODULE_UPLOAD_FOLDER.'/'.'requisition_leave'.'/'.$rel_id.'/'.$file->file_name;
                  if(is_image($path)){ ?>
                  <img src="<?php echo  base_url(TIMESHEETS_PATH.'requisition_leave/'.$rel_id.'/'.$file->file_name); ?>" class="img img-responsive margin-auto">
                  <?php } else if(strpos($file->file_name,'.pdf') !== false ){ ?>
                  <iframe src="<?php echo base_url(TIMESHEETS_PATH.'requisition_leave/'.$rel_id.'/'.$file->file_name); ?>" height="100%" width="100%" frameborder="0"></iframe>
                  <?php }else if(strpos($file->file_name,'.jpeg') !== false ){ ?>
                  <iframe src="<?php echo base_url(TIMESHEETS_PATH.'requisition_leave/'.$rel_id.'/'.$file->file_name); ?>" height="100%" width="100%" frameborder="0"></iframe>
                  <?php }else if(strpos($file->file_name,'.jpg') !== false ){ ?>
                  <iframe src="<?php echo base_url(TIMESHEETS_PATH.'requisition_leave/'.$rel_id.'/'.$file->file_name); ?>" height="100%" width="100%" frameborder="0"></iframe>
                  <?php }else if(strpos($file->file_name,'.png') !== false ){ ?>
                  <iframe src="<?php echo base_url(TIMESHEETS_PATH.'requisition_leave/'.$rel_id.'/'.$file->file_name); ?>" height="100%" width="100%" frameborder="0"></iframe>
                  <?php }else if(strpos($file->file_name,'.gif') !== false ){ ?>
                  <iframe src="<?php echo base_url(TIMESHEETS_PATH.'requisition_leave/'.$rel_id.'/'.$file->file_name); ?>" height="100%" width="100%" frameborder="0"></iframe>
                  <?php } else if(strpos($file->file_name,'.xls') !== false ){ ?>
                  <iframe src='https://view.officeapps.live.com/op/embed.aspx?src=<?php echo  base_url(TIMESHEETS_PATH.'requisition_leave/'.$rel_id.'/'.$file->file_name); ?>' width='100%' height='100%' frameborder='0'>
                  </iframe>
                  <?php } else if(strpos($file->file_name,'.xlsx') !== false ){ ?>
                  <iframe src='https://view.officeapps.live.com/op/embed.aspx?src=<?php echo  base_url(TIMESHEETS_PATH.'requisition_leave/'.$rel_id.'/'.$file->file_name); ?>' width='100%' height='100%' frameborder='0'>
                  </iframe>
                  <?php } else if(strpos($file->filetype,'excel') !== false && empty($file->external)){ ?>
                  <iframe src='https://view.officeapps.live.com/op/embed.aspx?src=<?php echo base_url('modules/hrm/uploads/job_position/'.$file->rel_id.'/'.$file->file_name); ?>' width='100%' height='100%' frameborder='0'>
                  </iframe>
                  <?php } else if(strpos($file->file_name,'.doc') !== false ){ ?>
                  <iframe src='https://view.officeapps.live.com/op/embed.aspx?src=<?php echo  base_url(TIMESHEETS_PATH.'requisition_leave/'.$rel_id.'/'.$file->file_name); ?>' width='100%' height='100%' frameborder='0'>
                  </iframe>
                  <?php } else if(strpos($file->file_name,'.docx') !== false ){ ?>
                  <iframe src='https://view.officeapps.live.com/op/embed.aspx?src=<?php echo  base_url(TIMESHEETS_PATH.'requisition_leave/'.$rel_id.'/'.$file->file_name); ?>' width='100%' height='100%' frameborder='0'>
                  </iframe>
                  <?php } else if(is_html5_video($path)) { ?>
                  <video width="100%" height="100%" src="<?php echo site_url('download/preview_video?path='.protected_file_url_by_path($path).'&type='.$file->filetype); ?>" controls>
                     Your browser does not support the video tag.
                  </video>
                  <?php } else if(is_markdown_file($path) && $previewMarkdown = markdown_parse_preview($path)) {
                     echo html_entity_decode($previewMarkdown);
                  } else {
                     
                     echo '<p class="text-muted">'._l('no_preview_available_for_file').'</p>';
                      }?>
               </div>
            </div>
         </div>
         <div class="clearfix"></div>
         <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo _l('close'); ?></button>
         </div>
      </div>
      <!-- /.modal-content -->
   </div>
   <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
<?php $discussion_lang = get_project_discussions_language_array(); ?>
<?php require 'modules/timesheets/assets/js/_file_js.php'; ?>
