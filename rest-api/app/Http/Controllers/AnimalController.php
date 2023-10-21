<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AnimalController extends Controller
{
    private  $animals = ["Kucing", "Ayam", "Ikan"];

    public function index()
    {
        echo "Menampilkan data animals <br>";
        foreach ($this->animals as $index => $animal) {
            echo " - $animal" . "<br>";
        }
    }

    public function store(Request $request)
    {
        $name = $request->input('name');
        if ($name) {
            $this->index();
            echo "<br>";
            
            echo "Menambahkan hewan baru '$name' <br>";
            array_push($this->animals, $name);
            $this->index();
        } else {
            echo "Harap masukan hewan!." . "<br>";
        }
    }

    public function update(Request $request, $index)
    {
        $name = $request->input('name');

        if (array_key_exists($index, $this->animals)) {
            $this->index();
            echo "<br>";

            echo "Mengupdate data hewan index '$index' menjadi '$name' <br>";
            $this->animals[$index] = $name;
            $this->index();
        } else {
            echo "Hewan tidak ada!." . "<br>";
        }
    }

    public function destroy($index)
    {
        $this->index();
        echo "<br>";

        if (array_key_exists($index, $this->animals)) {
            echo "Menghapus data hewan index '$index' data '" . $this->animals[$index] . "' <br>";
            unset($this->animals[$index]);
            $this->index();
        } else {
            echo "Hewan tidak ada!" . "<br>";
        }
    }
}
