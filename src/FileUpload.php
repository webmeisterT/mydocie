<?php 
namespace App;

class FileUpload {
    private string $val, $name, $size, $error, $tempName, $filename, $extension, $filePath = "";
    private bool $status = false;

    public function __construct(string $postName)
    {
        $this->val = $postName;
    }
    public function setName () {
        $this->name = $_FILES[$this->val]['name'];
    }
    public function setTempName () {
        $this->tempName = $_FILES[$this->val]['tmp_name'];
    }
    public function setSize () {
        $this->size = $_FILES[$this->val]['size'];
    }
    public function setError ($errorValue) {
        $this->error = $errorValue;
    }
    public function setExtension () {
        $varext = explode('.', $this->name);
        $this->extension = strtolower(end($varext));
    }
    public function setFilename () {
        $this->filename = uniqid() . "." . $this->extension;
    }
    public function setFilePath (string $valueOfPath) {
        $this->filePath = $valueOfPath.$this->filename;
    }
    public function getName () {
        return $this->name;
    }
    public function getTempName () {
        return $this->tempName;
    }
    public function getSize () {
        return $this->size;
    }
    public function getError () {
        return $this->error;
    }
    public function getFilename () {
        return $this->filename;
    }
    public function getExtension () {
        return $this->extension;
    }
    public function getFilePath () {
        return $this->filePath;
    }
    public function uploadTheFile () {
        if ($this->getSize() < 125000) {
            if (move_uploaded_file($this->tempName, $this->filePath)) {
                $this->status = true;
            } else {
                $this->status = false;
            }
        } else {
            $this->setError('Your passport size exceeded 125kb. Choose another!');
            return $this;
            // exit;
        }
        return $this;
    }
    public function errorUpload () {
        if (!empty($this->error)) {
            return $this->error;
        }
    }
    public function isUploaded () {
            return $this->status;
    }
}
