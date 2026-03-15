$base='http://127.0.0.1:8000'

Write-Output "Starting E2E test against $base"

# choose an order id that actually exists (change as needed)
$orderId = 5

# Fetch payment page to get CSRF (use session to keep cookies)
$session = New-Object Microsoft.PowerShell.Commands.WebRequestSession
try {
    $r = Invoke-WebRequest "$base/order/$orderId/payment" -WebSession $session -UseBasicParsing -ErrorAction Stop
} catch {
    Write-Output "ERROR: cannot fetch payment page (order $orderId): $_"
    exit 1
}

if ($r.Content -match 'name="_token" value="([^"]+)"') { $token=$matches[1] } else { $token='' }
Write-Output "Found CSRF token for payment: $token"

$body = '{"payment_method":"cash"}'
try {
    $resp = Invoke-WebRequest -Uri "$base/order/$orderId/pay" -Method Post -Body $body -ContentType 'application/json' -Headers @{ 'X-CSRF-TOKEN'=$token; 'Accept'='application/json' } -WebSession $session -UseBasicParsing -ErrorAction Stop
    Write-Output "--- PAYMENT_RESPONSE ---"
    Write-Output $resp.Content
    Write-Output "--- END PAYMENT_RESPONSE ---"
} catch {
    Write-Output "ERROR posting payment: $_"
}

# Admin login
$session = New-Object Microsoft.PowerShell.Commands.WebRequestSession
try {
    $loginPage = Invoke-WebRequest "$base/admin/login" -WebSession $session -UseBasicParsing -ErrorAction Stop
} catch {
    Write-Output "ERROR fetching admin login page: $_"
    exit 1
}

if ($loginPage.Content -match 'name="_token" value="([^"]+)"') { $token2=$matches[1] } else { $token2='' }
Write-Output "Found CSRF token for admin login: $token2"

try {
    $loginResp = Invoke-WebRequest -Uri "$base/admin/login" -Method Post -Body @{ username='admin'; password='admin123'; _token=$token2 } -WebSession $session -UseBasicParsing -ErrorAction Stop
    Write-Output "LOGIN_STATUS: $($loginResp.StatusCode)"
} catch {
    Write-Output "ERROR posting admin login: $_"
}

try {
    $dash = Invoke-WebRequest "$base/admin/dashboard/data" -WebSession $session -Headers @{ 'Accept'='application/json' } -UseBasicParsing -ErrorAction Stop
    Write-Output "--- DASHBOARD_DATA ---"
    Write-Output $dash.Content
    Write-Output "--- END DASHBOARD_DATA ---"
} catch {
    Write-Output "ERROR fetching dashboard data: $_"
}
