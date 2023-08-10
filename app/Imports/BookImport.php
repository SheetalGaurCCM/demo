<?php

namespace App\Imports;

use App\Models\Book;
use Maatwebsite\Excel\Concerns\ToModel;
use App\Models\Category;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\Auth;

class BookImport implements ToModel,WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $categoryNames = explode(',', $row['categories']);
        $categoryIds = [];

        foreach ($categoryNames as $categoryName) {
            $category = Category::firstOrCreate(['name' => $categoryName]);
            $categoryIds[] = $category->id;
        }

        $book = new Book([
            'title' => $row['title'],
            'author_name' => $row['author_name'],
            'description' => $row['description'],
            'price' => $row['price'],
            'user_id' => Auth::id(),
        ]);

        $book->save();

        $book->categories()->attach($categoryIds);

        return $book;
    }
}
