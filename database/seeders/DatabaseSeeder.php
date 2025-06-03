<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            'name' => 'kudv',
            'password' => Hash::make('password123'),
            'email' => 'thasv5424@gmail.com'
        ]);

        DB::table('domains')->insert([
            'name' => 'kubet88.ink',
            'amount' => 2.98,
            'purchase_date' => Carbon::createFromFormat('d/m/Y', '26/04/2023'),
            'expired_date' => Carbon::createFromFormat('d/m/Y', '26/04/2024'),
            'provider' => 'namecheap'
        ]);

        DB::table('domains')->insert([
            'name' => 'kubet88.fan',
            'amount' => 6.5,
            'purchase_date' => Carbon::createFromFormat('d/m/Y', '06/08/2023'),
            'expired_date' => Carbon::createFromFormat('d/m/Y', '06/06/2024'),
            'provider' => 'namecheap'
        ]);

        
        DB::table('domains')->insert([
            'name' => 'ku11.news',
            'amount' => 6.98,
            'purchase_date' => Carbon::createFromFormat('d/m/Y', '10/04/2023'),
            'expired_date' => Carbon::createFromFormat('d/m/Y', '10/04/2024'),
            'provider' => 'namecheap'
        ]);

        
        DB::table('domains')->insert([
            'name' => 'kubet77.news',
            'amount' => 12,
            'purchase_date' => Carbon::createFromFormat('d/m/Y', '28/03/2023'),
            'expired_date' => Carbon::createFromFormat('d/m/Y', '28/03/2025'),
            'provider' => 'godaddy'
        ]);

        DB::table('domains')->insert([
            'name' => 'kubet88.bio',
            'amount' => 2.14,
            'purchase_date' => Carbon::createFromFormat('d/m/Y', '22/04/2023'),
            'expired_date' => Carbon::createFromFormat('d/m/Y', '22/04/2024'),
            'index_opening_date' => Carbon::createFromFormat('d/m/Y', '12/06/2023'),
            'provider' => 'namecheap'
        ]);

        DB::table('domains')->insert([
            'name' => 'kubet88.team',
            'amount' => 3.64,
            'purchase_date' => Carbon::createFromFormat('d/m/Y', '22/04/2023'),
            'expired_date' => Carbon::createFromFormat('d/m/Y', '22/04/2024'),
            'index_opening_date' => Carbon::createFromFormat('d/m/Y', '03/01/2023'),
            'provider' => 'namecheap'
        ]);

        DB::table('domains')->insert([
            'name' => 'kubet77.bet',
            'amount' => 15,
            'purchase_date' => Carbon::createFromFormat('d/m/Y', '26/02/2023'),
            'expired_date' => Carbon::createFromFormat('d/m/Y', '26/02/2025'),
            'index_opening_date' => Carbon::createFromFormat('d/m/Y', '10/06/2023'),
            'provider' => 'godaddy'
        ]);

        DB::table('domains')->insert([
            'name' => 'kubet.cheap',
            'amount' => 6.16,
            'purchase_date' => Carbon::createFromFormat('d/m/Y', '19/04/2023'),
            'expired_date' => Carbon::createFromFormat('d/m/Y', '19/04/2025'),
            'index_opening_date' => Carbon::createFromFormat('d/m/Y', '01/06/2023'),
            'provider' => 'namecheap'
        ]);

        DB::table('domains')->insert([
            'name' => 'kubet.rocks',
            'amount' => 12,
            'purchase_date' => Carbon::createFromFormat('d/m/Y', '25/03/2023'),
            'expired_date' => Carbon::createFromFormat('d/m/Y', '25/03/2025'),
            'index_opening_date' => Carbon::createFromFormat('d/m/Y', '12/06/2023'),
            'provider' => 'namecheap'
        ]);

        DB::table('domains')->insert([
            'name' => 'thabet88.news',
            'amount' => 6.98,
            'purchase_date' => Carbon::createFromFormat('d/m/Y', '12/05/2023'),
            'expired_date' => Carbon::createFromFormat('d/m/Y', '12/05/2024'),
            'index_opening_date' => Carbon::createFromFormat('d/m/Y', '01/02/2023'),
            'provider' => 'namecheap'
        ]);
        
        DB::table('domains')->insert([
            'name' => 'kubet11.org',
            'amount' => 9.16,
            'purchase_date' => Carbon::createFromFormat('d/m/Y', '04/10/2023'),
            'expired_date' => Carbon::createFromFormat('d/m/Y', '04/10/2024'),
            'index_opening_date' => Carbon::createFromFormat('d/m/Y', '08/17/2023'),
            'provider' => 'namecheap'
        ]);

        DB::table('domains')->insert([
            'name' => 'kuku711.me',
            'amount' => 21,
            'purchase_date' => Carbon::createFromFormat('d/m/Y', '30/12/2020'),
            'expired_date' => Carbon::createFromFormat('d/m/Y', '30/12/2024'),
            'index_opening_date' => Carbon::createFromFormat('d/m/Y', '12/01/2021'),
            'provider' => 'namecheap'
        ]);

        DB::table('domains')->insert([
            'name' => 'kucasino88.me',
            'amount' => 12,
            'purchase_date' => Carbon::createFromFormat('d/m/Y', '25/03/2023'),
            'expired_date' => Carbon::createFromFormat('d/m/Y', '25/03/2024'),
            'index_opening_date' => Carbon::createFromFormat('d/m/Y', '01/06/2023'),
            'provider' => 'godaddy'
        ]);

        DB::table('domains')->insert([
            'name' => 'kubetzz.biz',
            'amount' => 5.66,
            'purchase_date' => Carbon::createFromFormat('d/m/Y', '06/06/2023'),
            'expired_date' => Carbon::createFromFormat('d/m/Y', '06/06/2024'),
            'index_opening_date' => Carbon::createFromFormat('d/m/Y', '16/06/2023'),
            'provider' => 'namecheap'
        ]);

        DB::table('domains')->insert([
            'name' => 'dangkykubet.news',
            'amount' => 6.98,
            'purchase_date' => Carbon::createFromFormat('d/m/Y', '05/05/2023'),
            'expired_date' => Carbon::createFromFormat('d/m/Y', '05/05/2024'),
            'index_opening_date' => Carbon::createFromFormat('d/m/Y', '01/07/2023'),
            'provider' => 'namecheap'
        ]);

        DB::table('domains')->insert([
            'name' => 'taikubet.news',
            'amount' => 7.16,
            'purchase_date' => Carbon::createFromFormat('d/m/Y', '21/04/2023'),
            'expired_date' => Carbon::createFromFormat('d/m/Y', '21/04/2024'),
            'index_opening_date' => Carbon::createFromFormat('d/m/Y', '01/07/2023'),
            'provider' => 'namecheap'
        ]);

        DB::table('domains')->insert([
            'name' => 'kubetvnz.com',
            'amount' => 9.76,
            'purchase_date' => Carbon::createFromFormat('d/m/Y', '25/05/2023'),
            'expired_date' => Carbon::createFromFormat('d/m/Y', '25/05/2024'),
            'provider' => 'namecheap'
        ]);

        DB::table('domains')->insert([
            'name' => 'ku11.work',
            'amount' => 5.98,
            'purchase_date' => Carbon::createFromFormat('d/m/Y', '22/04/2023'),
            'expired_date' => Carbon::createFromFormat('d/m/Y', '22/04/2025'),
            'index_opening_date' => Carbon::createFromFormat('d/m/Y', '01/07/2023'),
            'provider' => 'namecheap'
        ]);

        DB::table('domains')->insert([
            'name' => 'thabet.cool',
            'amount' => 5.98,
            'purchase_date' => Carbon::createFromFormat('d/m/Y', '10/07/2023'),
            'expired_date' => Carbon::createFromFormat('d/m/Y', '10/07/2024'),
            'index_opening_date' => Carbon::createFromFormat('d/m/Y', '12/01/2023'),
            'provider' => 'namecheap'
        ]);

        DB::table('domains')->insert([
            'name' => 'kubet.mov',
            'amount' => 13.16,
            'purchase_date' => Carbon::createFromFormat('d/m/Y', '10/07/2023'),
            'expired_date' => Carbon::createFromFormat('d/m/Y', '10/07/2024'),
            'index_opening_date' => Carbon::createFromFormat('d/m/Y', '01/05/2023'),
            'provider' => 'namecheap'
        ]);

        DB::table('domains')->insert([
            'name' => 'ku11.chat',
            'amount' => 8.98,
            'purchase_date' => Carbon::createFromFormat('d/m/Y', '26/04/2023'),
            'expired_date' => Carbon::createFromFormat('d/m/Y', '26/04/2024'),
            'index_opening_date' => Carbon::createFromFormat('d/m/Y', '10/10/2023'),
            'provider' => 'namecheap'
        ]);

        DB::table('domains')->insert([
            'name' => 'thabet.chat',
            'amount' => 9,
            'purchase_date' => Carbon::createFromFormat('d/m/Y', '16/09/2023'),
            'expired_date' => Carbon::createFromFormat('d/m/Y', '16/09/2024'),
            'index_opening_date' => Carbon::createFromFormat('d/m/Y', '04/05/2023'),
            'provider' => 'namecheap'
        ]);

        DB::table('domains')->insert([
            'name' => 'kubet.chat',
            'amount' => 9,
            'purchase_date' => Carbon::createFromFormat('d/m/Y', '21/07/2023'),
            'expired_date' => Carbon::createFromFormat('d/m/Y', '21/07/2024'),
            'index_opening_date' => Carbon::createFromFormat('d/m/Y', '04/04/2023'),
            'provider' => 'namecheap'
        ]);

        DB::table('domains')->insert([
            'name' => 'shbet.mov',
            'amount' => 13,
            'purchase_date' => Carbon::createFromFormat('d/m/Y', '16/09/2023'),
            'expired_date' => Carbon::createFromFormat('d/m/Y', '16/09/2024'),
            'index_opening_date' => Carbon::createFromFormat('d/m/Y', '01/10/2023'),
            'provider' => 'namecheap'
        ]);

        DB::table('domains')->insert([
            'name' => 'kubet88.tools',
            'amount' => 4.16,
            'purchase_date' => Carbon::createFromFormat('d/m/Y', '25/05/2023'),
            'expired_date' => Carbon::createFromFormat('d/m/Y', '25/05/2024'),
            'index_opening_date' => Carbon::createFromFormat('d/m/Y', '12/11/2023'),
            'provider' => 'namecheap'
        ]);

        DB::table('ctv')->insert([
            'account_id' => 'erictran21'
        ]);

        DB::table('ctv')->insert([
            'account_id' => 'seozzzz'
        ]);

        DB::table('ctv')->insert([
            'account_id' => 'lmssplus'
        ]);

        DB::table('ctv')->insert([
            'account_id' => 'betseo55555'
        ]);

        DB::table('ctv')->insert([
            'account_id' => 'lode799'
        ]);

        DB::table('ctv')->insert([
            'account_id' => 'panda2309'
        ]);

        DB::table('ctv')->insert([
            'account_id' => 'seoabcd'
        ]);

        DB::table('ctv')->insert([
            'account_id' => 'sakka0221'
        ]);

        DB::table('ctv')->insert([
            'account_id' => 'khaminhho'
        ]);

        DB::table('redirect_action')->insert([
            'from_domain_id' => 2,
            'to_domain_id' => 1,
            'impl_date' => Carbon::createFromFormat('d/m/Y', '07/10/2023')
        ]);
        
        DB::table('text_links')->insert([
            'domain_id' => 1,
            'target_domain' => 'ku11.link',
            'impl_date' => Carbon::createFromFormat('d/m/Y', '03/11/2023'),
            'expired_date' => Carbon::createFromFormat('d/m/Y','03/12/2023'),
            'anchor_text' => 'KUBET88',
            'amount' => 1200000,
            'ctv_id' => 1,
            'status' => false
        ]);
        
        DB::table('text_links')->insert([
            'domain_id' => 2,
            'target_domain' => 'ku11.link',
            'impl_date' => Carbon::createFromFormat('d/m/Y', '03/11/2023'),
            'expired_date' => Carbon::createFromFormat('d/m/Y','03/12/2023'),
            'anchor_text' => 'KUBET88',
            'amount' => 1200000,
            'ctv_id' => 1,
            'status' => false
        ]);

        DB::table('text_links')->insert([
            'domain_id' => 3,
            'target_domain' => 'phegame.net',
            'impl_date' => Carbon::createFromFormat('d/m/Y', '06/11/2023'),
            'expired_date' => Carbon::createFromFormat('d/m/Y','06/12/2023'),
            'text_link_full' => 'Trang chủ Kubet: https://ku11.news',
            'anchor_text' => 'https://ku11.news',
            'amount' => 800000,
            'ctv_id' => 1,
            'status' => false
        ]);

        DB::table('text_links')->insert([
            'domain_id' => 3,
            'target_domain' => 'dohigaming.com',
            'impl_date' => Carbon::createFromFormat('d/m/Y', '18/12/2023'),
            'expired_date' => Carbon::createFromFormat('d/m/Y','18/01/2024'),
            'anchor_text' => 'ku11',
            'amount' => 500000,
            'ctv_id' => 1,
            'status' => false
        ]);

        DB::table('text_links')->insert([
            'domain_id' => 3,
            'target_domain' => 'lmssplus.com',
            'impl_date' => Carbon::createFromFormat('d/m/Y', '08/12/2023'),
            'expired_date' => Carbon::createFromFormat('d/m/Y','08/03/2024'),
            'anchor_text' => 'ku11',
            'amount' => 5000000,
            'ctv_id' => 3,
            'status' => false
        ]);

        DB::table('text_links')->insert([
            'domain_id' => 4,
            'target_domain' => 'lmssplus.com',
            'impl_date' => Carbon::createFromFormat('d/m/Y', '08/12/2023'),
            'expired_date' => Carbon::createFromFormat('d/m/Y','08/03/2024'),
            'anchor_text' => 'kubet77',
            'amount' => 5000000,
            'ctv_id' => 3,
            'status' => false
        ]);

        DB::table('proxies')->insert([
            'provider' => 'itself',
            'is_usable' => 1
        ]);

        DB::table('proxies')->insert([
            'user_name' => 'autoproxy_Ilz6AHTn',
            'password' => 'r7xSPGsTL1',
            'ip' => '172.104.62.206',
            'port' => '5006',
            'is_usable' => 1
        ]);

        DB::table('domains')->insert([
            'name' => 'kubet.show',
            'amount' => 4.16,
            'purchase_date' => Carbon::createFromFormat('d/m/Y', '25/05/2023'),
            'expired_date' => Carbon::createFromFormat('d/m/Y', '25/05/2024'),
            'index_opening_date' => Carbon::createFromFormat('d/m/Y', '12/11/2023'),
            'provider' => 'namecheap'
        ]);

        // DB::table('guest_posts')->insert([
        //     'domain_id' => 3,
        //     'ctv_id' => 1,
        //     'target_domain' => 'khiphach.vip',
        //     'impl_date' => Carbon::createFromFormat('d/m/Y', '03/12/2023'),
        //     'status' => false,
        //     'amount' => 700000,
        //     'source_link' => 'https://docs.google.com/document/d/1keu3a7QsgwEdhHDfqJ8MciXvFIyITiwgQCptUoYGcsU',
        //     'post_link' => 'https://khiphach.vip/soi-3-cang-mien-bac/',
        // ]);

        // DB::table('guest_posts')->insert([
        //     'domain_id' => 4,
        //     'ctv_id' => 1,
        //     'target_domain' => 'khiphach.vip',
        //     'impl_date' => Carbon::createFromFormat('d/m/Y', '03/12/2023'),
        //     'status' => false,
        //     'amount' => 700000,
        //     'source_link' => 'https://docs.google.com/document/d/1fMTq93lcUISLAvYY-JEfZZvfFOkqAwuEG-bIOw1pDgs',
        //     'post_link' => 'https://khiphach.vip/cach-bat-cau-tai-xiu/',
        // ]);

        // DB::table('guest_posts')->insert([
        //     'domain_id' => 21,
        //     'ctv_id' => 1,
        //     'target_domain' => '8888kbet.com',
        //     'impl_date' => Carbon::createFromFormat('d/m/Y', '19/10/2023'),
        //     'status' => false,
        //     'amount' => 600000,
        //     'source_link' => 'https://docs.google.com/document/d/1C1F5D8qDzCy8HyLm-_vzvEp6aRyzyICgDu1FhXs5M4Q/edit',
        //     'post_link' => 'https://8888kbet.com/lo-truot-la-gi-bat-mi-cach-choi-lo-truot-de-trung-nhat/',
        // ]);
        
        // DB::table('guest_posts')->insert([
        //     'domain_id' => 4,
        //     'ctv_id' => 1,
        //     'target_domain' => 'anonyviet.com',
        //     'impl_date' => Carbon::createFromFormat('d/m/Y', '12/08/2023'),
        //     'status' => false,
        //     'amount' => 120000000,
        //     'source_link' => 'https://docs.google.com/document/d/1vYypR7wXcHwZUJfXkOOsxlsTa5djhLZgrxfzOB3Ig98',
        //     'post_link' => 'https://anonyviet.com/cach-choi-blackjack-kubet/',
        // ]);

        // DB::table('guest_posts')->insert([
        //     'domain_id' => 26,
        //     'ctv_id' => 1,
        //     'target_domain' => 'kiemdongcuuthien.vn',
        //     'impl_date' => Carbon::createFromFormat('d/m/Y', '07/09/2023'),
        //     'status' => false,
        //     'amount' => 700000,
        //     'source_link' => 'https://docs.google.com/document/d/1AynuU8mMV9PNWlmLIlmwbXcXDRH4JvGMAIE6HX1gsPc/edit',
        //     'post_link' => 'https://kiemdongcuuthien.vn/hack-game-kubet.html',
        // ]);

        // DB::table('guest_posts')->insert([
        //     'domain_id' => 19,
        //     'ctv_id' => 1,
        //     'target_domain' => '11mtv.com',
        //     'impl_date' => Carbon::createFromFormat('d/m/Y', '10/09/2023'),
        //     'status' => false,
        //     'amount' => 1300000,
        //     'source_link' => 'https://docs.google.com/document/d/1aXR93X7F1e3TSMAsPQPk4bPYdlMrvF51nc_dlOxBEoI/edit',
        //     'post_link' => 'https://11mtv.com/tai-xiu-4-45-la-gi-ca-cuoc-truc-tuyen/',
        // ]);

        // DB::table('guest_posts')->insert([
        //     'domain_id' => 2,
        //     'ctv_id' => 1,
        //     'target_domain' => 'cacuoc365.org',
        //     'impl_date' => Carbon::createFromFormat('d/m/Y', '11/10/2023'),
        //     'status' => false,
        //     'amount' => 1000000,
        //     'source_link' => 'https://docs.google.com/document/d/1em2BNim6xVpS8Si2NxJ28g7g9km0HhPRyzgApOnYay8',
        //     'post_link' => 'https://cacuoc365.org/hack-xoc-dia-kubet88-co-that-hay-khong/',
        // ]);

        // DB::table('guest_posts')->insert([
        //     'domain_id' => 18,
        //     'ctv_id' => 1,
        //     'target_domain' => 'cacuoc365.org',
        //     'impl_date' => Carbon::createFromFormat('d/m/Y', '11/10/2023'),
        //     'status' => false,
        //     'amount' => 1000000,
        //     'source_link' => 'https://docs.google.com/document/d/1ZwbW33xJVESH9EGUF4b9XuTIi_WOyeGIIen8mbbPsps',
        //     'post_link' => 'https://cacuoc365.org/cach-danh-xoc-dia-tren-ku11/',
        // ]);

        // DB::table('guest_posts')->insert([
        //     'domain_id' => 3,
        //     'ctv_id' => 1,
        //     'target_domain' => 'khiphach.vip',
        //     'impl_date' => Carbon::createFromFormat('d/m/Y', '03/12/2023'),
        //     'status' => false,
        //     'amount' => 700000,
        //     'source_link' => 'https://docs.google.com/document/d/1keu3a7QsgwEdhHDfqJ8MciXvFIyITiwgQCptUoYGcsU',
        //     'post_link' => 'https://khiphach.vip/soi-3-cang-mien-bac/',
        // ]);

        DB::table('guest_posts')->insert([
            'domain_id' => 4,
            'ctv_id' => 1,
            'target_domain' => 'khiphach.vip',
            'impl_date' => Carbon::createFromFormat('d/m/Y', '03/12/2023'),
            'status' => false,
            'amount' => 700000,
            'source_link' => 'https://docs.google.com/document/d/1fMTq93lcUISLAvYY-JEfZZvfFOkqAwuEG-bIOw1pDgs',
            'post_link' => 'https://khiphach.vip/cach-bat-cau-tai-xiu/',
        ]);

        DB::table('guest_posts')->insert([
            'domain_id' => 4,
            'ctv_id' => 1,
            'target_domain' => 'khiphach.vip',
            'impl_date' => Carbon::createFromFormat('d/m/Y', '03/12/2023'),
            'status' => false,
            'amount' => 700000,
            'source_link' => 'https://docs.google.com/document/d/1WVWAvl9UkQP3c6aHP5DlSxE2WTeBw8EcBiAK2ZyJfbs/edit',
            'post_link' => 'https://yo88.life/cach-danh-lo-de-kubet-khong-phai-game-thu-nao-cung-biet/',
        ]);

        DB::table('guest_posts')->insert([
            'domain_id' => 4,
            'ctv_id' => 1,
            'target_domain' => 'khiphach.vip',
            'impl_date' => Carbon::createFromFormat('d/m/Y', '03/12/2023'),
            'status' => false,
            'amount' => 700000,
            'source_link' => 'https://docs.google.com/document/d/1WVWAvl9UkQP3c6aHP5DlSxE2WTeBw8EcBiAK2ZyJfbs/edit',
            'post_link' => 'https://xosotructiep.me/danh-bai-truc-tuyen-ku-casino/',
        ]);

        DB::table('guest_posts')->insert([
            'domain_id' => 4,
            'ctv_id' => 1,
            'target_domain' => 'khiphach.vip',
            'impl_date' => Carbon::createFromFormat('d/m/Y', '03/12/2023'),
            'status' => false,
            'amount' => 700000,
            'source_link' => 'https://docs.google.com/document/d/1WVWAvl9UkQP3c6aHP5DlSxE2WTeBw8EcBiAK2ZyJfbs/edit',
            'post_link' => 'https://206.189.146.184/chi-tiet-ve-quy-luat-xoc-dia/',
        ]);

        DB::table('guest_posts')->insert([
            'domain_id' => 4,
            'ctv_id' => 1,
            'target_domain' => 'khiphach.vip',
            'impl_date' => Carbon::createFromFormat('d/m/Y', '03/12/2023'),
            'status' => false,
            'amount' => 700000,
            'source_link' => 'https://docs.google.com/document/d/1WVWAvl9UkQP3c6aHP5DlSxE2WTeBw8EcBiAK2ZyJfbs/edit',
            'post_link' => 'https://gamestory.vn/tin-game/ban-ca-hai-vuong.html',
        ]);
    }
}
