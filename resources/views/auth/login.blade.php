<x-guest-layout>
     <h1>Atte</h1>
     
    <x-auth-card>
        <x-slot name="logo">
            <a href="/">
           
            </a>
        </x-slot>

        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')" />

        <!-- Validation Errors -->
        <x-auth-validation-errors class="mb-4" :errors="$errors" />

        <form method="POST" action="{{ route('login') }}">
            @csrf
　　　　　　　 <h2>ログイン</h2>
            <!-- Email Address -->
            <div>
               
                <x-label for="email" :value="__('Email')" />

                <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus />
            </div>

            <!-- Password -->
            <div class="mt-4">
                <x-label for="password" :value="__('Password')" />

                <x-input id="password" class="block mt-1 w-full"
                                type="password"
                                name="password"
                                required autocomplete="current-password" />
            </div>
                <x-button class="flex items-center ml-3">
                    {{ __('Log in') }}
                </x-button>
            </div>
            
　　　　　　　　<a class="ml-2">アカウントをお持ちでない方はこちらから
              </a>
                

            
                <a class="text-gray-600 hover:text-gray-900" href="{{ route('register') }}">
                    {{ __('会員登録') }}
                </a>

               
          
        </form>
    </x-auth-card>
</x-guest-layout>
