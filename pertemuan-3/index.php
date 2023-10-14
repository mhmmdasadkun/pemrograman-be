<?php

class Animal
{
    // Properties
    private $animals;

    // Methods
    public function __construct() // Constructor
    {
        $this->animals = array("Ayam", "Ikan");
    }

    public function index()
    {
        foreach ($this->animals as $index => $animal) {
            echo " - $animal" . "<br>";
        }
    }

    public function store($data = null)
    {
        if ($data) {
            array_push($this->animals, $data);
            $this->index();
        } else {
            echo "Harap masukan hewan!." . "<br>";
        }
    }

    public function update($index, $data)
    {
        if (array_key_exists($index, $this->animals)) {
            $this->animals[$index] = $data;
            $this->index();
        } else {
            echo "Hewan tidak ada!." . "<br>";
        }
    }

    public function destroy($index)
    {
        if (array_key_exists($index, $this->animals)) {
            unset($this->animals[$index]);
            $this->index();
        } else {
            echo "Hewan tidak ada!" . "<br>";
        }
    }
}

// Contoh penggunaan
$animal = new Animal();

echo "Index - Menampilkan seluruh hewan <br>";
$animal->index();
echo "<br>";

echo "Store - Menambahkan hewan baru (Burung) <br>";
$animal->store("Burung");
echo "<br>";

echo "Update - Mengupdate hewan (Ayam) menjadi (Macan) <br>";
$animal->update(0, "Macan");
echo "<br>";

echo "Destroy - Menghapus hewan (Ikan) <br>";
$animal->destroy(1);
echo "<br>";
