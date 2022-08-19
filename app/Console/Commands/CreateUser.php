<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class CreateUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'users:create';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new user';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        // ask for the name of the user to create
        $name = $this->ask('请输入用户名');
        // ask for the email of the user to create
        $email = $this->ask('请输入邮箱');

        // enter password
        $password = $this->secret('请输入密码(密码不会显示在终端)');

        // create the user
        User::create([
            'name' => $name,
            'email' => $email,
            'password' => bcrypt($password),
        ]);

        $this->info('用户创建成功！');
        return 0;
    }
}
