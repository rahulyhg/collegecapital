/*
Copyright (c) 2003-2011, CKSource - Frederico Knabben. All rights reserved.
For licensing, see LICENSE.html or http://ckeditor.com/license
*/

CKEDITOR.editorConfig = function( config )
{
	// Define changes to default configuration here. For example:
	config.language = 'en-au';
	config.uiColor = '#C0C0C0';
	config.height = '25em';
	/*config.pasteFromWordRemoveFontStyles=false;
	config.pasteFromWordRemoveStyles=false;*/
	// This is actually the default value.
	config.toolbar_Full =
	[
		{ name: 'document',    items : [ 'Source','-','Save','NewPage','DocProps','Preview','Print','-','Templates' ] },
		{ name: 'clipboard',   items : [ 'Cut','Copy','Paste','PasteText','PasteFromWord','-','Undo','Redo','-','SpellChecker', 'Scayt'  ] },
		{ name: 'links',       items : [ 'Link','Unlink','Anchor' ] },
		{ name: 'insert',      items : [ 'Image','Flash','Table','HorizontalRule' ] },
		'/',
		{ name: 'basicstyles', items : [ 'Bold','Italic','Underline','-','RemoveFormat' ] },
		{ name: 'paragraph',   items : [ 'NumberedList','BulletedList','-','Outdent','Indent','-','Blockquote','CreateDiv','-','JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock','-','BidiLtr','BidiRtl' ] },
		{ name: 'styles',      items : [ 'Format','FontSize' ] }
	];
	
	config.toolbar_Basic =
	[
		['Bold', 'Italic','Underline','-','Cut','Copy','Paste','PasteText','PasteFromWord','-','NumberedList', 'BulletedList', 'Link', 'Unlink','Image']
	];
	
	config.toolbar_Deter =
	[
		{ name: 'document',    items : [ 'Source'] },
		{ name: 'clipboard',   items : [ 'Cut','Copy','Paste','PasteText','PasteFromWord'] },
		{ name: 'basicstyles', items : [ 'Bold','Italic','Underline' ] }
		
		/*['Source', '-', 'Bold', 'Italic','Underline','-','Cut','Copy','Paste','PasteText','PasteFromWord']*/
	];
	
	config.toolbar_Column =
	[
		['Source','-','Bold','Italic','Underline','-','Cut','Copy','Paste','-','Link','Unlink','Image']
	];
};