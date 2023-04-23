<?php

class Model
{
    public $id = null;
    public $tableName = '';

    public function __construct($id = null)
    {
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

    public function delete(): bool
    {
        // Check if id is set
        if (isset($this->id)) {
            // Delete
            Db::getInstance()->delete($this->tableName, $this->id);
        }

        return true;
    }
    
    public function save($bypassHtml = false): bool
    {
        // Get all properties from class
        $properties = get_object_vars($this);

        // Filter off table name from properties
        unset($properties['tableName']);

        // Filter off id from properties
        unset($properties['id']);

        $data = Db::getInstance()->query('DESCRIBE `' . $this->tableName . '`', [], true);

        // Loop through data and get only Field name
        foreach ($data as $key => $value) {
            $data[$key] = $value->Field;
        }

        // Loop through properties
        foreach ($properties as $key => $value) {
            // Check if property exists in db
            if (!in_array($key, $data)) {
                // Remove property from array
                unset($properties[$key]);
                continue;
            }

            // If empty or null then return false
            if (empty($value)) {
                unset($properties[$key]);
                continue;
            }

            // $bypassHtml is used to bypass html filtering
            if (!$bypassHtml) {
                // Filter html
                $properties[$key] = filter_var($value, FILTER_SANITIZE_STRING);
            }
        }

        // Check if id is set
        if (isset($this->id)) {
            // Check if date_upd exists in db
            if (in_array('date_upd', $data)) {
                // Set date_upd
                $properties['date_upd'] = date('Y-m-d H:i:s');
            }
            
            // Update
            Db::getInstance()->update($this->tableName, $properties, $this->id);
        } else {
            // Check if date_add and date_upd exists in db
            if (in_array('date_add', $data)) {
                // Set date_add
                $properties['date_add'] = date('Y-m-d H:i:s') . '.000';
            }

            if (in_array('date_upd', $data)) {
                // Set date_upd
                $properties['date_upd'] = date('Y-m-d H:i:s') . '.000';
            }
            
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

    public static function getByFields(array $values): static
    {
        // Get data from db
        $data = Db::getInstance()->table(get_called_class());

        foreach ($values as $key => $value) {
            $data = $data->where($key, $value);
        }

        $data = $data->get()->first();

        if (!$data) {
            return new static();
        }

        return new static($data->id);
    }

    public static function getAllByField(string $field, $value, $orderBy = null, $order = null): array
    {
        // Get data from db
        $data = Db::getInstance()->table(get_called_class())->where($field, $value);

        if ($orderBy && $order) {
            $data = $data->orderBy($orderBy, $order);
        }

        $data = $data->get();

        if (!$data) {
            return new static();
        }

        $listOfData = [];

        foreach ($data as $key => $value) {
            $listOfData[] = new static($value->id);
        }

        return $listOfData;
    }

    public static function getAll(int $page, int $limit, $orderBy = null, $order = null): array
    {
        $data = Db::getInstance()->table(get_called_class());

        if ($orderBy && $order) {
            $data = $data->orderBy($orderBy, $order);
        }

        $data = $data->paginate($page, $limit);

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
