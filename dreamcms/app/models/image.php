<?php
class Image extends AppModel {
	var $name = 'Image';
	var $displayField = 'name';

	var $validate = array(
		'name' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => 'Please enter image name.',
			),
		),
		'location' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => 'Please select an image to upload.',
			),
		),
	);
	
	//The Associations below have been created with all possible keys, those that are not needed can be removed
	var $belongsTo = array(
		'Categorie' => array(
			'className' => 'Categorie',
			'foreignKey' => 'categorie_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

	var $hasAndBelongsToMany = array(
		'Tag' => array(
			'className' => 'Tag',
			'joinTable' => 'images_tags',
			'foreignKey' => 'image_id',
			'associationForeignKey' => 'tag_id',
			'unique' => true,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'finderQuery' => '',
			'deleteQuery' => '',
			'insertQuery' => ''
		)
	);
	
	// TODO: error messages
	// TODO: think about method scheme
	// TODO: retrieve different pictures to save from root model
	function saveImage($fileData,$thumbSizeMax,$thumbSizeType,$thumbQuality) {
		App::import('Vendor','ccImageResize', array('file' => 'ccImageResize.class.php'));
		$fileData['name'] = $this->getLocationName($fileData['name']);
		$uploadedPath = WWW_ROOT . "img/original/" . $fileData['name'];
		if (move_uploaded_file($fileData['tmp_name'], $uploadedPath)) {
			$resizer = new ccImageResize;
			
			if ($resizer->resizeImage($uploadedPath, WWW_ROOT . "img/thumbnails/" . $fileData['name'], $thumbSizeMax,$thumbSizeType,$thumbQuality)) {
				// ok, everything is fine
			} else {
				// error with thumbnail resize
				return NULL;		
			}
			
			if ($resizer->resizeImage($uploadedPath, WWW_ROOT . "img/medium/" . $fileData['name'], 600,$thumbSizeType,$thumbQuality)) {
				// ok, everything is fine
			} else {
				// error with medium resize
				return NULL;
			}
			
			if ($resizer->resizeImage($uploadedPath, WWW_ROOT . "img/large/" . $fileData['name'], 900,$thumbSizeType,$thumbQuality)) {
				// ok, everything is fine
			} else {
				// error with medium resize
				return NULL;
			}	
					
		} else {
			// TODO: Set error message if move_uploaded_file fails
			//die("Could not move uploaded file ++" . $fileData['location'] . " ++ " . $fileData['name']);
			return NULL;
		}
		return $fileData['name'];
	}
	
	function delImage($filename)
	{
		// TODO: Code for condition where unlink fails
		// TODO: Retrieve different pictures from root model		
		if(is_file(WWW_ROOT . "img/thumbnails/" . $filename)) {
			unlink(WWW_ROOT . "img/thumbnails/" . $filename);
		}
		if(is_file(WWW_ROOT . "img/medium/" . $filename)) {
			unlink(WWW_ROOT . "img/medium/" . $filename);
		}
		if(is_file(WWW_ROOT . "img/large/" . $filename)) {
			unlink(WWW_ROOT . "img/large/" . $filename);
		}
		if(is_file(WWW_ROOT . "img/original/" . $filename)) {
			unlink(WWW_ROOT . "img/original/" . $filename);
		}
		return true;
	}
	
	private function getLocationName($fileName) {
		if(file_exists(WWW_ROOT . "img/original/" . $fileName))
		{
			$found = true;
			for($i = 1; $found == true; $i++)
			{
				$proposedName = $i . $fileName;
				$found = file_exists(WWW_ROOT . "img/original/" . $proposedName);
			}
			return $proposedName;
		}
		else
		{
			return $fileName;
		}
	}
	
}
?>