<?php
namespace Classes\FileUpload;
/**
 * @name UploadException
 */
class UploadException extends SpecialException {};

/**
 * @name Upload
 * @filesource Upload.php
 * 
 * @author Cyril Nicodème
 * @license Gnu/Agpl
 * @version 0.1
 * 
 * @since 12/01/2008
 */
class FileUpload {
	/**
	 * @property Constants of designed error
	 */
	const UNAUTHORIZED_FORM_SIZE 	= 1;		// The file size is over the form authorized size
	const UNAUTHORIZED_SIZE 	= 2;		// The file size is over the authorized size
	const UNALLOWED_EXTENSION 	= 3;		// The file does not have an authorized extension
	const ILLEGAL_FILE_NAME 	= 4;		// The file contains Illegal Characters
	
	const INCOMPLETE_FILE 		= 10;		// The file was not completely uploaded
	const UNUPLOADED_FILE 		= 11;		// No file was uploaded
	const INVALID_FILE 		= 12;		// The file is not a valid uploaded file
	const INVALID_IMAGE_FILE 	= 13;		// The file is not a valid Image File
	
	const UNABLE_CREATE_FOLDER 	= 20;		// Unable to create a subfolder
	const INEXISTANT_DESTINATION 	= 21;		// Destination Folder does not exists !
	const EXISTANT_FILE 		= 22;		// The file already exists
	const INEXISTANT_FILE 		= 23;		// The file does not exists
	const UNABLE_TO_MOVE 		= 24;		// Unable to upload the file. Maybe you haven\'t to write into the folder ?
	
	/**
	 * @var Array $_aParameters
	 * Contain all the parameters
	 */
	private $_aParameters = array (
		// @var String : Contain the Path to the destination folder
		'destinationFolder' => '',
	
		// @var String : Contain the name of the file
		'fileName' => '',
	
		// @var String : Contain the destination folder + the file name
		'filePath' => '',
	
		// @var Array : Contain an array of Allowed extensions. If it's an empty array, all the extensions will be allowed
		'allowedExt' => array (),
	
		// @var boolean : Indicate if we rename the file (if already exists) or not
		'rename' => false,
	
		// @var boolean : Indicate if we cleaning the file from strange characters (allow only alphanumeric, ., - and _)
		'cleanFileName' => false,
	
		// @var boolean : Indicate if we create the subfolder for the destinationFolder value
		'createSubFolders' => true,
	
		// @var int : Indicate the max file size for the uploaded file
		'maxFileSize' => 0,
	
		// @var boolean : Indicate if we need to check if the file is an image
		'isImage' => false);
	
	/**
	 * @name __set
	 * Modify the values : destinationFolder, fileName, filePath, allowedExt, rename, cleanFileName, createSubFolders, maxFileSize, isImage
	 * 
	 * @param String $sKey
	 * @param Mixed (String, Array, Boolean) $mValue
	 * 
	 * @return void
	 */
	public function __set ($sKey, $mValue) {
		if (!is_string ($sKey))
			throw new InvalidParameterException (InvalidParameterException::STRING_NEEEDED, 1);
		
		switch (strtolower ($sKey)) {
			case 'destinationfolder':
				if (!is_string ($mValue))
					throw new InvalidParameterException (InvalidParameterException::STRING_NEEEDED, 2);
				
				$mValue = str_replace(array ("\\", "/"), DIRECTORY_SEPARATOR, $mValue);
				
				if (substr ($mValue, -1) != DIRECTORY_SEPARATOR)
					$mValue .= DIRECTORY_SEPARATOR;
				$this->_aParameters['destinationFolder'] = $mValue;
				break;
			case 'filename':
				if (!is_string ($mValue))
					throw new InvalidParameterException (InvalidParameterException::STRING_NEEEDED, 2);
				
				$this->_aParameters['fileName'] = $mValue;
				break;
			case 'filepath':
				if (!is_string ($mValue))
					throw new InvalidParameterException (InvalidParameterException::STRING_NEEEDED, 2);
					
				$mValue = str_replace(array ("\\", "/"), DIRECTORY_SEPARATOR, $mValue);
				$this->_aParameters['destinationFolder'] = substr ($mValue, 0, strrpos ($mValue, DIRECTORY_SEPARATOR)+1);
				$this->_aParameters['fileName'] = substr ($mValue, strrpos ($mValue, DIRECTORY_SEPARATOR)+1);
				$this->_aParameters['filePath'] = $mValue;
				break;
			case 'allowedext':
				if (!is_array ($mValue))
					throw new InvalidParameterException (InvalidParameterException::ARRAY_NEEEDED, 2);
				
				$this->_aParameters['allowedExt'] = $mValue;
				break;
			case 'rename':
				if (!is_bool ($mValue))
					throw new InvalidParameterException (InvalidParameterException::BOOLEAN_NEEDED, 2);
				
				$this->_aParameters['rename'] = $mValue;
				break;
			case 'cleanfilename':
				if (!is_bool ($mValue))
					throw new InvalidParameterException (InvalidParameterException::BOOLEAN_NEEDED, 2);
				
				$this->_aParameters['cleanFileName'] = $mValue;
				break;
			case 'createsubfolders':
				if (!is_bool ($mValue))
					throw new InvalidParameterException (InvalidParameterException::BOOLEAN_NEEDED, 2);
				
				$this->_aParameters['createSubFolders'] = $mValue;
				break;
			case 'maxfilesize':
				if (!is_int ($mValue))
					throw new InvalidParameterException (InvalidParameterException::INT_NEEDED, 2);
				
				$this->_aParameters['maxFileSize'] = $mValue;
				break;
			case 'isimage':
				if (!is_bool ($mValue))
					throw new InvalidParameterException (InvalidParameterException::BOOLEAN_NEEDED, 2);
				
				$this->_aParameters['isImage'] = $mValue;
				break;
			default:
				throw new InvalidParameterException (InvalidParameterException::INVALID_KEY, $sKey);
		}
	}
	
	/**
	 * @name __get
	 * Get the values : destinationFolder, fileName, filePath, allowedExt, rename, cleanFileName, createSubFolders, maxFileSize, isImage
	 * 
	 * @param String $sKey
	 * 
	 * @return Mixed (String, Array, Boolean)
	 */
	public function __get ($sKey) {
		if (!is_string ($sKey))
			throw new InvalidParameterException (InvalidParameterException::STRING_NEEEDED, 1);
		
		if (isset ($this->_aParameters [$sKey]))
			return $this->_aParameters [$sKey];
		else
			throw new InvalidParameterException (InvalidParameterException::INVALID_KEY, $sKey);
	}
	
	/**
	 * @name addAllowedExtension
	 * Add a specific extension or an array of extensions
	 * 
	 * @param Mixed (Array, String) $mValue
	 * 
	 * @return void
	 */
	public function addAllowedExtension ($mValue) {
		if (is_array ($mValue))
			$this->_aParameters['allowedExt'] = array_merge ($this->_aParameters['allowedExt'], $mValue);
			elseif (is_string ($mValue))
		$this->_aParameters['allowedExt'] [] = $mValue;
		else
			throw new InvalidParameterException (InvalidParameterException::STRING_NEEEDED + InvalidParameterException::ARRAY_NEEEDED, 1);
	}
	
	/**
	 * @name cleanAllowedExtension
	 * Set the $_aAllowedExt array empty
	 * 
	 * @return void
	 */
	public function cleanAllowedExtension () {
		$this->_aParameters['allowedExt'] = array ();
	}
	
	/**
	 * @name createSubFolders
	 * Create sub folders from a specific path or from the $_sDestinationFolder
	 * 
	 * @param String $sFolderToCreate (optional)
	 * 
	 * @return void
	 */
	public function createSubFolders  ($sFolderToCreate=null) {
		if (isset ($sFolderToCreate) && !is_string ($sFolderToCreate))
			throw new InvalidParameterException (InvalidParameterException::STRING_NEEEDED, 1);
		if (!isset ($sFolderToCreate))
			$sFolderToCreate = $this->_aParameters['destinationFolder'];
		
		$aFolders = explode (DIRECTORY_SEPARATOR, $sFolderToCreate);
		$sFinalFolder = '';
		foreach ($aFolders as $sFolder) {
			$sFinalFolder .= $sFolder.DIRECTORY_SEPARATOR;
			if (!is_dir ($sFinalFolder)) {
				if (!mkdir ($sFinalFolder))
					throw new UploadException (UploadHelper::UNABLE_CREATE_FOLDER);
			}
		}
	}
	
	/**
	 * @name cleanFileName
	 * Modify the value to be only alphanumeric, _, - and .
	 * 
	 * @param String $sFileName
	 * 
	 * @return String
	 */
	public function cleanFileName ($sFileName) {
		if (!is_string ($sFileName))
			throw new InvalidParameterException (InvalidParameterException::STRING_NEEEDED, 1);
		
		$aSearch = array ('#à|â|ä#i', '#é|è|ê|ë#i', '#î|ï#i', '#ô|ö#i', '#ù|û|ü#i', '#ç#i', '#&#i', '#@#i', "# |'#", '#"#', '#[^a-zA-Z0-9_\.-]*#i');
		$aReplace = array('a', 'e', 'i', 'o', 'u', 'c', '_and_', 'at', '_');
		return preg_replace($aSearch, $aReplace, strtolower($sFileName));
	}
	
	/**
	 * @name renameFile
	 * Rename a specific value while the file from the given file path exists and return the new file path
	 * 
	 * @param String $sFilePath
	 * 
	 * @return String
	 */
	public function renameFile ($sFilePath) {
		if (!is_string ($sFilePath))
			throw new InvalidParameterException (InvalidParameterException::STRING_NEEEDED, 1);
		
		$sFileName = substr ($sFilePath, strrpos ($sFilePath, DIRECTORY_SEPARATOR)+1);
		$sDestinationFolder = substr ($sFilePath, 0, strrpos ($sFilePath, DIRECTORY_SEPARATOR)+1);
		
		$sBaseName = substr ($sFileName, 0, strrpos ($sFileName, '.'));
		$sExtension = '.'.preg_replace ('`.*\.([^\.]*)$`', '$1', $sFileName);
		
		$sAdd = '';
		$iWhile = 0;
		
		while (file_exists ($sDestinationFolder.$sBaseName.$sAdd.$sExtension)) {
			$sAdd = '('.$iWhile.')';
			$iWhile++;
		}
		
		return $sDestinationFolder.$sBaseName.$sAdd.$sExtension;
	}
	
	/**
	 * @name isImage
	 * Get if the file is an image or not
	 * 
	 * @param String $sFilePath
	 * 
	 * @return Boolean
	 */
	public function isImage ($sFilePath) {
		if (!is_string ($sFilePath))
			throw new InvalidParameterException (InvalidParameterException::STRING_NEEEDED, 1);
		
		if (!file_exists ($sFilePath))
			throw new UploadException (UploadHelper::INEXISTANT_FILE);
		
		$aParams = @getimagesize($sFilePath);
		
		/*
		 * 1  = IMAGETYPE_GIF
		 * 2  = IMAGETYPE_JPEG
		 * 3  = IMAGETYPE_PNG
		 * 4  = IMAGETYPE_SWF
		 * 5  = IMAGETYPE_PSD
		 * 6  = IMAGETYPE_BMP
		 * 7  = IMAGETYPE_TIFF_II (ordre d'octets d'Intel)
		 * 8  = IMAGETYPE_TIFF_MM (ordre d'octets Motorola)
		 * 9  = IMAGETYPE_JPC
		 * 10 = IMAGETYPE_JP2
		 * 11 = IMAGETYPE_JPX
		 * 12 = IMAGETYPE_JB2
		 * 13 = IMAGETYPE_SWC
		 * 14 = IMAGETYPE_IFF
		 * 15 = IMAGETYPE_WBMP
		 * 16 = IMAGETYPE_XBM
		 */
		if (!isset ($aParams[2]))
			return false;
		elseif ($aParams[2] > 0 && $aParams[2] < 16)
			return true;
		else
			return false;
	}
	
	/**
	 * @name upload
	 * Upload the file given into the $_sDestinationFolder given and return the file path
	 * 
	 * @param Array $aSubmittedFile
	 * 
	 * @return String
	 */
	public function upload ($aSubmittedFile) {
		if (!is_array ($aSubmittedFile))
			throw new InvalidParameterException (InvalidParameterException::STRING_NEEEDED, 1);
		
		if ($aSubmittedFile['error'] == UPLOAD_ERR_INI_SIZE)
			throw new \Exception (FileUpload::UNAUTHORIZED_SIZE);
		
		if ($aSubmittedFile['error'] == UPLOAD_ERR_FORM_SIZE)
			throw new \Exception (FileUpload::UNAUTHORIZED_FORM_SIZE);
		
		if ($aSubmittedFile['error'] == UPLOAD_ERR_PARTIAL)
			throw new \Exception (FileUpload::INCOMPLETE_FILE);
		
		if ($aSubmittedFile['error'] == UPLOAD_ERR_NO_FILE)
			throw new \Exception (FileUpload::UNUPLOADED_FILE);
		
		if (!is_uploaded_file ($aSubmittedFile['tmp_name']))
			throw new \Exception (FileUpload::INVALID_FILE);
		
		if (isset ($this->_aParameters['maxFileSize']) && filesize ($aSubmittedFile['tmp_name']) > $this->_aParameters['maxFileSize'])
			throw new \Exception (FileUpload::UNAUTHORIZED_SIZE);
		
		if (preg_match('#[\x00-\x1F\x7F-\x9F/\\\\]#', $aSubmittedFile['name']))
			throw new \Exception (FileUpload::ILLEGAL_FILE_NAME);
		
		if ((count ($this->_aParameters['allowedExt']) > 0) && 
			!(in_array (preg_replace ('`.*\.([^\.]*)$`', '$1', $aSubmittedFile['name']), $this->_aParameters['allowedExt'])))
			throw new \Exception (FileUpload::UNALLOWED_EXTENSION);
		
		if ($this->_aParameters['isImage'] && !$this->isImage($aSubmittedFile['tmp_name']))
			throw new \Exception (FileUpload::INVALID_IMAGE_FILE);
		
		if (!is_dir ($this->_aParameters['destinationFolder']) && $this->_aParameters['createSubFolders'])
			$this->createSubFolders ();
		
		if (!is_dir ($this->_aParameters['destinationFolder']) && !$this->_aParameters['createSubFolders'])
			throw new \Exception (FileUpload::INEXISTANT_DESTINATION);
		
		$sFileName = (isset ($this->_aParameters['fileName'])) ? $this->_aParameters['fileName'] : $aSubmittedFile['name'];
		
		if ($this->_aParameters['cleanFileName'])
			$sFileName = $this->cleanFileName ($sFileName);
		
		$sFilePath = $this->_aParameters['destinationFolder'].$sFileName;

		if (file_exists ($sFilePath) && !$this->_aParameters['rename'])
			throw new \Exception (FileUpload::EXISTANT_FILE);
			
		if (file_exists ($sFilePath) && $this->_aParameters['rename'])
			$sFilePath = $this->renameFile ($sFilePath);
		
		if (!move_uploaded_file ($aSubmittedFile['tmp_name'], $sFilePath))
			throw new \Exception (FileUpload::UNABLE_TO_MOVE);
		
		$this->_aParameters['filePath'] = $sFilePath;
		return $sFilePath;
	}
}
?>
