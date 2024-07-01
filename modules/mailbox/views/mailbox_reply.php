<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php echo form_open_multipart($this->uri->uri_string(), ['id'=>'mailbox_compose_form']); ?>
<div class="clearfix mtop20"></div>
<div class="row">
  <div class="col-md-12">
    <div class="form-group">      
    <i class="fa fa-question-circle pull-left" data-toggle="tooltip" data-title="<?php echo _l('mailbox_multi_email_split'); ?>"></i>
    <?php
      $to      = '';
      $subject = '';
      if ('inbox' == $action_type) {
          if ('reply' == $method) {
              $subject = 'RE: '.$mail->subject;
			  $from_email = $mail->from_email;
			  $split = explode(' <', $from_email);
			  $name = $split[0];
			  $from_email = rtrim($split[1], '>');
              $to      = $from_email;
          } elseif ('replyall' == $method) {
              $subject = 'RE: '.$mail->subject;
              $to      = $mail->from_email.';'.$mail->to.';'.$mail->cc;
          } else {
              $subject = 'FW: '.$mail->subject;
          }
      } else {
          if ('reply' == $method) {
              $subject = 'RE: '.$mail->subject;
              $to      = $mail->to;
          } elseif ('replyall' == $method) {
              $subject = 'RE: '.$mail->subject;
              $to      = $mail->to;
          } else {
              $subject = 'FW: '.$mail->subject;
          }
      }
    ?>
    <?php echo form_hidden('reply_from_id'); ?>
    <?php echo render_input('to', 'mailbox_to', $to); ?>
    <?php echo render_input('cc', 'CC'); ?>
    <?php echo render_input('subject', 'mailbox_subject', $subject); ?>
	<?php
        $CI = &get_instance();
        $CI->db->select()
            ->from(db_prefix().'staff')
            ->where(db_prefix().'staff.mail_password !=', '');
        $staffs = $CI->db->get()->result_array();
        foreach ($staffs as $staff) {
            $mail_signature = $staff['mail_signature'];
        }
    ?>
    <hr />    
    <?php echo render_textarea('body', '', $mail->body.$mail_signature, [], [], '', 'tinymce tinymce-compose'); ?>    
    </div>
    <div class="attachments">
      <div class="attachment">
        <div class="mbot15">
          <div class="form-group">
            <label for="attachment" class="control-label"><?php echo _l('ticket_add_attachments'); ?></label>
            <div class="input-group">
              <input type="file" extension="<?php echo str_replace('.', '', get_option('ticket_attachments_file_extensions')); ?>" filesize="<?php echo file_upload_max_size(); ?>" class="form-control" name="attachments[0]" accept="<?php echo get_ticket_form_accepted_mimes(); ?>">
              <span class="input-group-btn">
                <button class="btn btn-success add_more_attachments p8-half" data-max="<?php echo get_option('maximum_allowed_ticket_attachments'); ?>" type="button"><i class="fa fa-plus"></i></button>
              </span>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="btn-group pull-left">
      <a href="<?php echo admin_url().'mailbox'; ?>" class="btn btn-warning close-send-template-modal"><?php echo _l('cancel'); ?></a>      
    </div>

    <div class="pull-right">            
      <button type="submit" autocomplete="off" data-loading-text="<?php echo _l('wait_text'); ?>" class="btn btn-info">
          <i class="fa fa-paper-plane menu-icon"></i>
          <?php echo _l('mailbox_send'); ?>          
        </button>
    </div>
</div>
</div>
<?php echo form_close(); ?>