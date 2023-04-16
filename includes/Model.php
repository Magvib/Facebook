<?php

class Model {
    public $id = null;
    public $tableName = '';

    public function __construct($id = null) {
        // Set table name class name fx. User
        $this->tableName = get_class($this);

        if ($id == null) {
            return;
        }
        
        // Get all properties from class
        $properties = get_object_vars($this);

        // Get data from db
        $data = Db::getInstance()->table($this->tableName)->where('id', $id)->get()->first();

        // Loop through properties
        foreach ($properties as $key => $value) {
            // Check if property exists in db
            if (isset($data->$key)) {
                // Set property to db value
                $this->$key = $data->$key;
            }
        }
    }

    public function save(): bool
    {
        // Get all properties from class
        $properties = get_object_vars($this);

        // Filter off table name from properties
        unset($properties['tableName']);

        // Filter off id from properties
        unset($properties['id']);

        $data = Db::getInstance()->query('DESCRIBE ' . $this->tableName, [], true);

        // Loop through data and get only Field name
        foreach ($data as $key => $value) {
            $data[$key] = $value->Field;
        }

        $error = false;
        // Loop through properties
        foreach ($properties as $key => $value) {
            // Check if property exists in db
            if (!in_array($key, $data)) {
                // Remove property from array
                unset($properties[$key]);
            }

            // If empty or null then return false
            if (empty($value) && !in_array($key, ['id', 'date_add', 'date_upd'])) {
                $error = true;
            }
        }

        // Check if error
        if ($error) {
            return false;
        }

        // Check if id is set
        if (isset($this->id)) {
            // Update
            Db::getInstance()->update($this->tableName, $properties, $this->id);
        } else {
            // Insert
            Db::getInstance()->insert($this->tableName, $properties);
        }

        return true;
    }

    public static function getByField(string $field, $value): static
    {
        // Get data from db
        $data = Db::getInstance()->table(get_called_class())->where($field, $value)->get()->first();

        if (!$data) {
            return new static();
        }

        return new static($data->id);
    }

    public static function getAllByField(string $field, $value): array
    {
        // Get data from db
        $data = Db::getInstance()->table(get_called_class())->where($field, $value)->get();

        if (!$data) {
            return new static();
        }

        $listOfData = [];

        foreach ($data as $key => $value) {
            $listOfData[] = new static($value->id);
        }

        return $listOfData;
    }
}