<?php

namespace Database\Seeders;

use App\Models\Post;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Post::insert([
            [
                'status' => 'Hello, this is my first post!',
                'user_id' => 1, // Admin
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'status' => 'semuanya harus turut perintah atmin kalo gamawu di kick',
                'user_id' => 1, // Admin
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'status' => '@rifqi saya peringatkan ya 😠',
                'user_id' => 1, // Admin
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'status' => '@rifqi sekali lagi saya kick kamu 😡',
                'user_id' => 1, // Admin
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'status' => '@rifqi ini perintah atmin 🤬',
                'user_id' => 1, // Admin
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'status' => 'Welcome to my profile!',
                'user_id' => 2, // User 1
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'status' => 'Ada peribahasa yang mengacu pada batang bambu yang mengeluarkan air putih. "Sehitam-hitamnya batang pasti keluarnya bisa putih, seburuk-buruknya seseorang pasti hatinya juga bisa bersih"',
                'user_id' => 2, // User 1
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'status' => 'Ambativasi tanpa aksi hanyalah ilusi 😎',
                'user_id' => 2, // User 1
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'status' => 'Woylahh sigma banget gwejh bjir 🗿',
                'user_id' => 2, // User 1
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'status' => 'Pop Mie menggoda bgt coy 🤤',
                'user_id' => 2, // User 1
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'status' => 'Ketika mimpimu yang begitu indah tak pernah terwujud, ywdh si 😅. Peduli apa gwejh 😒',
                'user_id' => 2, // User 1
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'status' => 'Katanya dev yang bikin app ini guanteng bgt jir',
                'user_id' => 2, // User 1
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'status' => 'What a great day!, if we start our day by eating some kangkung',
                'user_id' => 3, // User 2
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'status' => 'jaga ucapanmu wahai @rifqi, saya bisa mempermalukanmu dengan sekali screenshot saja',
                'user_id' => 3, // User 2
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'status' => 'aplikasi ini asik sebelum @rifqi mulai mempost statusnya',
                'user_id' => 3, // User 2
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'status' => 'ges emg iya @rifqi org ngawi aseli?',
                'user_id' => 3, // User 2
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'status' => 'kayaknya sih iya ngawi banget jir',
                'user_id' => 3, // User 2
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'status' => 'Hello World!',
                'user_id' => 4, // User 3
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'status' => 'The important thing is not to stop questioning. Curiosity has its own reason for existing. - Albert Einstein',
                'user_id' => 4,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'status' => 'Science is the key to our future, and if you don’t believe in science, then you’re holding everybody back. - Bill Nye',
                'user_id' => 4,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'status' => 'In the middle of difficulty lies opportunity. - Albert Einstein',
                'user_id' => 4,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'status' => 'Research is what I’m doing when I don’t know what I’m doing. - Wernher von Braun',
                'user_id' => 4,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'status' => 'It is far better to grasp the universe as it really is than to persist in delusion, however satisfying and reassuring. - Carl Sagan',
                'user_id' => 4,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'status' => 'Somewhere, something incredible is waiting to be known. - Carl Sagan',
                'user_id' => 4,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'status' => 'Science and everyday life cannot and should not be separated. - Rosalind Franklin',
                'user_id' => 4,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'status' => 'We cannot solve our problems with the same thinking we used when we created them. - Albert Einstein',
                'user_id' => 4,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'status' => 'What I cannot create, I do not understand. - Richard Feynman',
                'user_id' => 4,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'status' => 'Equipped with his five senses, man explores the universe around him and calls the adventure Science. - Edwin Hubble',
                'user_id' => 4,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'status' => 'Life would be tragic if it weren’t funny. - Stephen Hawking',
                'user_id' => 4,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'status' => 'Imagination will often carry us to worlds that never were. But without it, we go nowhere. - Carl Sagan',
                'user_id' => 4,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'status' => 'The good thing about science is that it’s true whether or not you believe in it. - Neil deGrasse Tyson',
                'user_id' => 4,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'status' => 'The greatest enemy of knowledge is not ignorance; it is the illusion of knowledge. - Stephen Hawking',
                'user_id' => 4,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'status' => 'Success is a science; if you have the conditions, you get the result. - Oscar Wilde',
                'user_id' => 4,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'status' => 'An expert is a person who has made all the mistakes that can be made in a very narrow field. - Niels Bohr',
                'user_id' => 4,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'status' => 'The true sign of intelligence is not knowledge but imagination. - Albert Einstein',
                'user_id' => 4,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'status' => 'Genius is one percent inspiration and ninety-nine percent perspiration. - Thomas Edison',
                'user_id' => 4,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'status' => 'Time is a created thing. To say “I don’t have time” is like saying, “I don’t want to.” - Lao Tzu',
                'user_id' => 4,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'status' => 'Knowledge is power. - Francis Bacon',
                'user_id' => 4,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
