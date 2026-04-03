<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - Valeria Coffee</title>
    <style>
        body { 
            background-color: #FDFBF7; 
            margin: 0; 
            font-family: 'Plus Jakarta Sans', 'Segoe UI', sans-serif; 
        }
        
        .input-field:focus { 
            border-color: #A06040; 
            outline: none; 
            box-shadow: 0 0 5px rgba(160, 96, 64, 0.2); 
        }
        
        .btn-login:hover { 
            background-color: #2D1F18 !important; 
            transform: translateY(-1px); 
            transition: 0.3s; 
        }

        /* Menghilangkan dekorasi default */
        input::placeholder {
            color: #C0B0A0;
            opacity: 0.7;
        }
    </style>
</head>
<body>

<div style="display: flex; align-items: center; justify-content: center; min-height: 100vh;">
    <div class="login-container" style="width: 100%; max-width: 400px; padding: 20px;">
        
        <div style="background: white; padding: 40px; border-radius: 24px; box-shadow: 0 10px 25px rgba(60, 42, 33, 0.05); border: 1px solid #F5EBE0;">
            
            <div style="text-align: center; font-size: 40px; margin-bottom: 10px;">☕</div>
            
            <h2 style="text-align: center; color: #3C2A21; margin-bottom: 8px; font-size: 26px; font-weight: 800; letter-spacing: -0.5px; text-transform: uppercase;">
                Admin <span style="color: #A06040;">Login</span>
            </h2>
            <p style="text-align: center; color: #8C786D; font-size: 13px; margin-bottom: 30px; font-weight: 500; letter-spacing: 1px; text-transform: uppercase;">
                Valeria Coffee Management
            </p>
            
            {{-- Perbaikan pada route action: Diarahkan ke admin.login.submit --}}
            <form action="{{ route('admin.login.submit') }}" method="POST">
                @csrf
                
                <div style="margin-bottom: 22px;">
                    <label style="display: block; font-size: 12px; font-weight: 700; color: #3C2A21; margin-bottom: 8px; text-transform: uppercase; letter-spacing: 1px;">Email Address</label>
                    <input type="email" name="email" value="{{ old('email') }}" required 
                           class="input-field"
                           placeholder="admin@valeriacoffee.id"
                           style="width: 100%; padding: 12px 15px; border: 2px solid #F5EBE0; border-radius: 12px; box-sizing: border-box; font-size: 14px; background: #FCFAFA;">
                </div>

                <div style="margin-bottom: 25px;">
                    <label style="display: block; font-size: 12px; font-weight: 700; color: #3C2A21; margin-bottom: 8px; text-transform: uppercase; letter-spacing: 1px;">Password</label>
                    <input type="password" name="password" required 
                           class="input-field"
                           placeholder="admin123"
                           style="width: 100%; padding: 12px 15px; border: 2px solid #F5EBE0; border-radius: 12px; box-sizing: border-box; font-size: 14px; background: #FCFAFA;">
                </div>

                <button type="submit" class="btn-login" 
                        style="width: 100%; padding: 14px; background: #3C2A21; color: #FDFBF7; border: none; border-radius: 12px; cursor: pointer; font-size: 14px; font-weight: 800; text-transform: uppercase; letter-spacing: 2px; box-shadow: 0 4px 12px rgba(60, 42, 33, 0.2);">
                    Sign In
                </button>
                
                @if($errors->any())
                    <div style="background: #FFF5F5; border-left: 4px solid #A06040; color: #A06040; padding: 12px; margin-top: 25px; font-size: 13px; border-radius: 8px; font-weight: 600;">
                        {{ $errors->first() }}
                    </div>
                @endif
            </form>
        </div>
        
        <p style="text-align: center; margin-top: 25px; font-size: 11px; color: #8C786D; font-weight: 600; letter-spacing: 1px; text-transform: uppercase; opacity: 0.6;">
            &copy; 2026 Valeria Coffee Hub
        </p>
    </div>
</div>

</body>
</html>