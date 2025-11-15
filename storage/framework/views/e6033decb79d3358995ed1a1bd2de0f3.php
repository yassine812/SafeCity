<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>SafeCity — Inscription</title>

    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        :root {
            --grad-start:#b6e0ff;
            --grad-end:#f3b8d8;
            --card-bg:#ffffff;
            --accent:#ff7fbf;
            --input:#e8f2fb;
        }

        body {
            background: linear-gradient(120deg, var(--grad-start), var(--grad-end));
            font-family: 'Inter', sans-serif;
        }

        .register-card {
            max-width: 980px;
            margin: 7vh auto;
            background: var(--card-bg);
            border-radius: 22px;
            overflow: hidden;
            display: grid;
            grid-template-columns: 1fr 420px;
            box-shadow: 0 18px 40px rgba(0,0,0,0.14);
        }

        .left-side {
            padding: 55px;
        }

        .title {
            font-size: 38px;
            font-weight: 700;
            color: #0f172a;
        }

        input {
            background: var(--input);
            border: none;
            outline: none;
            width: 100%;
            padding: 12px 16px;
            border-radius: 10px;
            color: #0f172a;
        }

        .btn-register {
            background: linear-gradient(90deg, var(--accent), #ff9ac9);
            border-radius: 999px;
            color: #fff;
            font-weight: 600;
            padding: 11px 20px;
            width: 100%;
            box-shadow: 0px 6px 15px rgba(255, 127, 191, 0.25);
        }

        .right-side {
            background: linear-gradient(180deg, rgba(255,255,255,0.45), rgba(255,255,255,0.75));
            display:flex;
            align-items:center;
            justify-content:center;
        }

        .character-img {
            width: 490px;
            height: 450px;
            background-image: url('<?php echo e(asset("images/illustration.png")); ?>');
            background-size: contain;
            background-repeat: no-repeat;
            background-position: center;
            transform: scaleX(-1);
        }

        @media(max-width:900px){
            .register-card { grid-template-columns: 1fr; }
            .right-side { display: none; }
        }
    </style>
</head>

<body>

<div class="register-card">

    <!-- LEFT SIDE -->
    <div class="left-side">

        <div class="flex items-center mb-2">
            <div class="w-8 h-8 bg-pink-500 rounded-full flex items-center justify-center mr-3">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd" />
                </svg>
            </div>
            <span class="text-2xl font-bold bg-gradient-to-r from-pink-500 to-purple-600 bg-clip-text text-transparent">
                SafeCity
            </span>
        </div>

        <div class="relative mb-8">
            <h1 class="text-3xl font-bold text-gray-800 mb-1">Créer un compte</h1>
            <p class="text-gray-500">Rejoignez SafeCity dès aujourd'hui</p>
            <div class="absolute -bottom-4 left-0 w-16 h-1 bg-gradient-to-r from-pink-500 to-purple-600 rounded-full"></div>
        </div>


        <form method="POST" action="<?php echo e(route('register')); ?>" class="space-y-5">
            <?php echo csrf_field(); ?>

            <!-- NAME -->
            <div>
                <label class="text-sm text-gray-500">Nom</label>
                <input type="text" name="name" value="<?php echo e(old('name')); ?>" required autofocus>
                <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-xs text-red-600 mt-1"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <!-- EMAIL -->
            <div>
                <label class="text-sm text-gray-500">E-mail</label>
                <input type="email" name="email" value="<?php echo e(old('email')); ?>" required>
                <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-xs text-red-600 mt-1"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <!-- PASSWORD -->
            <div>
                <label class="text-sm text-gray-500">Mot de passe</label>
                <input type="password" name="password" required>
                <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-xs text-red-600 mt-1"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <!-- CONFIRM PASSWORD -->
            <div>
                <label class="text-sm text-gray-500">Confirmer le mot de passe</label>
                <input type="password" name="password_confirmation" required>
                <?php $__errorArgs = ['password_confirmation'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> 
                    <p class="text-xs text-red-600 mt-1"><?php echo e($message); ?></p> 
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <!-- REGISTER BUTTON -->
            <button type="submit" class="btn-register">S'INSCRIRE →</button>

            <!-- GOOGLE SIGN UP -->
            <div class="relative my-6">
                <div class="absolute inset-0 flex items-center">
                    <div class="w-full border-t border-gray-200"></div>
                </div>
                <div class="relative flex justify-center text-sm">
                    <span class="px-2 bg-white text-gray-400">ou</span>
                </div>
            </div>

            <!-- GOOGLE BUTTON -->
            <div class="flex justify-center">
                <a href="/auth/google" class="w-10 h-10 flex items-center justify-center border border-gray-200 rounded-full hover:bg-gray-50 transition-colors duration-200" title="S'inscrire avec Google" aria-label="S'inscrire avec Google">
                    <img src="https://www.svgrepo.com/show/475656/google-color.svg" width="20" alt="Google">
                </a>
            </div>

            <!-- SIGN IN LINK -->
            <div class="text-xs text-center mt-6 text-gray-500">
                Vous avez déjà un compte ?
                <a href="<?php echo e(route('login')); ?>" class="text-pink-500 font-medium hover:underline">
                    Connectez-vous ici
                </a>
            </div>
        </form>

    </div>

    <!-- RIGHT SIDE ILLUSTRATION -->
    <div class="right-side">
        <div class="character-img"></div>
    </div>

</div>

</body>
</html>
<?php /**PATH C:\Users\zerni\CascadeProjects\windsurf-project-8\SafeCity\resources\views/auth/register.blade.php ENDPATH**/ ?>