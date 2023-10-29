/**
 * @license Copyright (c) 2003-2023, CKSource Holding sp. z o.o. All rights reserved.
 * For licensing, see https://ckeditor.com/legal/ckeditor-oss-license
 */

CKEDITOR.editorConfig = function( config ) {
  config.filebrowserBrowseUrl = '/ckfinder/ckfinder.html';
  config.filebrowserUploadUrl = '/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files';

  config.removeDialogTabs = 'image:advanced;image:Link';
  // config.removeButtons = 'ExportPdf';
  // config.height = '111px';
  // config.width = '111px';
  config.resize_enabled = false;
  config.font_names = "新細明體;標楷體;微軟正黑體;" +config.font_names ;
  config.fontSize_sizes = '8/8px;9/9px;10/10px;11/11px;12/12px;14/14px;16/16px;18/18px;20/20px;22/22px;24/24px;26/26px;28/28px;30/30px;32/32px;34/34px;36/36px;40/40px;48/48px;56/56px;60/60px;72/72px;';
  
  config.filebrowserImageUploadUrl = '/_managre/ckeditor_img_upload_ex.php';
  config.width = '100%';
  config.height = 400;
  config.enterMode = CKEDITOR.ENTER_BR;
  config.allowedContent = true; 
};
