<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>SafeCity — Réinitialisation du mot de passe</title>

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

        .card {
            max-width: 980px;
            margin: 7vh auto;
            background: var(--card-bg);
            border-radius: 22px;
            overflow: hidden;
            display: grid;
            grid-template-columns: 1fr 420px;
            box-shadow: 0 18px 40px rgba(0,0,0,0.14);
        }

        .left-side { padding: 55px; }

        input {
            background: var(--input);
            padding: 12px 16px;
            border-radius: 10px;
            outline: none;
            border: none;
            width: 100%;
        }

        .btn {
            background: linear-gradient(90deg, var(--accent), #ff9ac9);
            border-radius: 999px;
            color: white;
            padding: 11px 20px;
            width: 100%;
            font-weight: 600;
        }

        .right-side {
            background: linear-gradient(180deg, rgba(255,255,255,0.45), rgba(255,255,255,0.75));
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .illustration {
            width: 490px;
            height: 450px;
            background-image: url('/images/illustration.png');
            background-size: contain;
            background-repeat: no-repeat;
            background-position: center;
            transform: scaleX(-1);
        }

        @media(max-width:900px){
            .card { grid-template-columns: 1fr; }
            .right-side { display: none; }
        }
    </style>
</head>

<body>

<div class="card">

    <div class="left-side">

        <!-- Header like login/register -->
        <div class="flex items-center mb-2">
            <div class="w-8 h-8 bg-pink-500 rounded-full flex items-center justify-center mr-3">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd" />
                </svg>
            </div>
            <span class="text-2xl font-bold bg-gradient-to-r from-pink-500 to-purple-600 bg-clip-text text-transparent">SafeCity</span>
        </div>

        <div class="relative mb-8">
            <h1 class="text-3xl font-bold text-gray-800 mb-1">Mot de passe oublié ?</h1>
            <p class="text-gray-500">Nous vous enverrons un lien de réinitialisation par e-mail.</p>
            <div class="absolute -bottom-4 left-0 w-16 h-1 bg-gradient-to-r from-pink-500 to-purple-600 rounded-full"></div>
        </div>

        <!-- STATUS MESSAGE -->
        <?php if(session('status')): ?>
            <div class="bg-green-50 border-l-4 border-green-500 p-4 mb-4 text-green-700">
                <?php echo e(session('status')); ?>

            </div>
        <?php endif; ?>

        <form method="POST" action="<?php echo e(route('password.email')); ?>" class="space-y-5">
            <?php echo csrf_field(); ?>

            <!-- Email -->
            <div>
                <label class="text-sm text-gray-500">E-mail</label>
                <input type="email" name="email" value="<?php echo e(old('email')); ?>" required autofocus>
                <?php $__errorArgs = ['email'];
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

            <!-- SEND BUTTON -->
            <button class="btn">Envoyer le lien de réinitialisation →</button>

            <!-- BACK TO LOGIN -->
            <div class="text-xs text-center text-gray-500 mt-3">
                Vous vous souvenez de votre mot de passe ?
                <a href="<?php echo e(route('login')); ?>" class="text-pink-500 hover:underline">Retour à la connexion</a>
            </div>
        </form>

    </div>

    <!-- Illustration -->
    <div class="right-side">
        <div class="illustration"></div>
    </div>

</div>

</body>
</html>
<?php /**PATH C:\Users\zerni\CascadeProjects\windsurf-project-8\SafeCity\resources\views/auth/forgot-password.blade.php ENDPATH**/ ?>