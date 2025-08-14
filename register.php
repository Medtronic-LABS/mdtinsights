<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once 'db.php';

$message = "";
$redirect = false;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST['name']);
    $organization = trim($_POST['organization']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    if ($name && $organization && $email && $phone && $password && $confirm_password) {
        if ($password !== $confirm_password) {
            $message = "<div class='error-message'>Passwords do not match.</div>";
        } else {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            $check_sql = "SELECT id FROM users WHERE email = ?";
            $check_stmt = $conn->prepare($check_sql);
            $check_stmt->bind_param("s", $email);
            $check_stmt->execute();
            $check_stmt->store_result();

            if ($check_stmt->num_rows > 0) {
                $update_sql = "UPDATE users SET password = ? WHERE email = ?";
                $update_stmt = $conn->prepare($update_sql);
                $update_stmt->bind_param("ss", $hashed_password, $email);
                if ($update_stmt->execute()) {
    			header("Location: /login.php");
    		exit();
		} else {
                    $message = "<div class='error-message'>Error updating password: " . htmlspecialchars($update_stmt->error) . "</div>";
                }
            } else {
                $county = isset($_POST['county']) ? trim($_POST['county']) : null;
                $subcounty = isset($_POST['subcounty']) ? trim($_POST['subcounty']) : null;
                $moh_type = isset($_POST['moh_type']) ? trim($_POST['moh_type']) : null;

                $insert_sql = "INSERT INTO users (name, organization, email, phone, password, county, moh_type, subcounty) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
                $insert_stmt = $conn->prepare($insert_sql);
                $insert_stmt->bind_param("ssssssss",$name, $organization, $email, $phone, $hashed_password, $county, $moh_type, $subcounty);

                if ($insert_stmt->execute()) {
    		header("Location: /login.php");
    		exit();
     		}

		else {
                    $message = "<div class='error-message'>Error: " . htmlspecialchars($insert_stmt->error) . "</div>";
                }
            }
        }
    } else {
        $message = "<div class='error-message'>Please fill in all required fields.</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="UTF-8">
    <link rel="icon" type="image/png" href="/images/fav.png">
    <title>Register</title>
    <link rel="stylesheet" href="styles.css">
    <script type="text/javascript">
        (function(c, l, a, r, i, t, y) {
            c[a] = c[a] || function() { (c[a].q = c[a].q || []).push(arguments); };
            t = l.createElement(r); t.async = 1; t.src = "https://www.clarity.ms/tag/" + i;
            y = l.getElementsByTagName(r)[0]; y.parentNode.insertBefore(t, y);
        })(window, document, "clarity", "script", "s7ifpngdg7");
    </script>
</head>
<body>

<?php
if (!empty($message)) echo $message;

if (!empty($redirect)) {
    echo "<script>setTimeout(function() { window.location.href = 'index.php'; }, 3000);</script>";
}
?>

<form action="register.php" method="POST">
    <label for="name">Full Name</label>
    <input type="text" id="name" name="name" placeholder="Full Name" required>

    <label for="organization">Organization</label>
    <select name="organization" id="organization" required onchange="handleOrgChange()">
        <option value="">Select Organization</option>
        <option value="Medtronic Labs">Medtronic Labs</option>
        <option value="Ministry of Health">MOH</option>
        <option value="Kenya Diabetes Management & Information Centre">DMI</option>
        <option value="Sierra Leone">Sierra Leone</option>
        <option value="Other">Other</option>
    </select>

    <div id="moh-options" style="display:none;">
        <label for="moh_type">MOH Level</label>
        <select name="moh_type" id="moh_type" onchange="handleMOHTypeChange()">
            <option value="">Select Level</option>
            <option value="National">National</option>
            <option value="County">County</option>
        </select>

        <div id="county-options" style="display:none;">
            <label for="county">Select Your County</label>
                <select name="county" id="county" >
                  <option value="">-- Select County --</option>
                  <option value="Baringo">Baringo</option>
                  <option value="Bomet">Bomet</option>
                  <option value="Bungoma">Bungoma</option>
                  <option value="Busia">Busia</option>
                  <option value="Elgeyo-Marakwet">Elgeyo-Marakwet</option>
                  <option value="Embu">Embu</option>
                  <option value="Garissa">Garissa</option>
                  <option value="Homa Bay">Homa Bay</option>
                  <option value="Isiolo">Isiolo</option>
                  <option value="Kajiado">Kajiado</option>
                  <option value="Kakamega">Kakamega</option>
                  <option value="Kericho">Kericho</option>
                  <option value="Kiambu">Kiambu</option>
                  <option value="Kilifi">Kilifi</option>
                  <option value="Kirinyaga">Kirinyaga</option>
                  <option value="Kisii">Kisii</option>
                  <option value="Kisumu">Kisumu</option>
                  <option value="Kitui">Kitui</option>
                  <option value="Kwale">Kwale</option>
                  <option value="Laikipia">Laikipia</option>
                  <option value="Lamu">Lamu</option>
                  <option value="Machakos">Machakos</option>
                  <option value="Makueni">Makueni</option>
                  <option value="Mandera">Mandera</option>
                  <option value="Marsabit">Marsabit</option>
                  <option value="Meru">Meru</option>
                  <option value="Migori">Migori</option>
                  <option value="Mombasa">Mombasa</option>
                  <option value="Murang'a">Murang'a</option>
                  <option value="Nairobi">Nairobi</option>
                  <option value="Nakuru">Nakuru</option>
                  <option value="Nandi">Nandi</option>
                  <option value="Narok">Narok</option>
                  <option value="Nyamira">Nyamira</option>
                  <option value="Nyandarua">Nyandarua</option>
                  <option value="Nyeri">Nyeri</option>
                  <option value="Samburu">Samburu</option>
                  <option value="Siaya">Siaya</option>
                  <option value="Taita Taveta">Taita Taveta</option>
                  <option value="Tana River">Tana River</option>
                  <option value="Tharaka-Nithi">Tharaka-Nithi</option>
                  <option value="Trans Nzoia">Trans Nzoia</option>
                  <option value="Turkana">Turkana</option>
                  <option value="Uasin Gishu">Uasin Gishu</option>
                  <option value="Vihiga">Vihiga</option>
                  <option value="Wajir">Wajir</option>
                  <option value="West Pokot">West Pokot</option>
                </select>


            <label for="subcounty">Subcounty</label>
            <select name="subcounty" id="subcounty">
                <option value="">-- Select Subcounty --</option>
            </select>
        </div>
    </div>

    <div id="other-org" style="display:none;">
        <label for="other_organization">Specify Organization</label>
        <input type="text" id="other_organization" name="other_organization" placeholder="Specify Organization">
    </div>

    <label for="email">Email</label>
    <input type="email" id="email" name="email" placeholder="Email" required>

    <label for="phone">Phone Number</label>
        <input 
            type="tel" 
            id="phone" 
            name="phone" 
            placeholder="0712345678" 
            pattern="[0-9]{10}" 
            maxlength="10" 
            required
        >

    <label for="password">Password</label>
    <input type="password" id="password" name="password" placeholder="Password" required>

    <label for="confirm_password">Confirm Password</label>
    <input type="password" id="confirm_password" name="confirm_password" placeholder="Confirm Password" required>
    <label>
    Data is secured and only used for Access and Usage View. I agree to share my data. <input type="checkbox" name="consent" required>
    </label>

    <button type="submit">Register</button>
</form>

<script>
function handleOrgChange() {
    const org = document.getElementById('organization').value;
    document.getElementById('moh-options').style.display = org === 'Ministry of Health' ? 'block' : 'none';
    document.getElementById('other-org').style.display = org === 'Other' ? 'block' : 'none';
    document.getElementById('county-options').style.display = 'none';
}

function handleMOHTypeChange() {
    const type = document.getElementById('moh_type').value;
    document.getElementById('county-options').style.display = type === 'County' ? 'block' : 'none';
}

const countySubcountyMap = {
  "Baringo": ["Baringo Central", "Baringo North", "Mogotio", "Tiaty"],
  "Bomet": ["Bomet Central", "Chepalungu", "Konoin", "Sotik"],
  "Bungoma": ["Bumula", "Kabuchai", "Kanduyi", "Kimilili"],
  "Busia": ["Butula", "Funyula", "Matayos", "Nambale"],
  "Elgeyo-Marakwet": ["Keiyo North", "Keiyo South", "Marakwet East", "Marakwet West"],
  "Embu": ["Manyatta", "Mbeere North", "Mbeere South", "Runyenjes"],
  "Garissa": ["Balambala", "Dadaab", "Fafi", "Garissa Township"],
  "Homa Bay": ["Homa Bay Town", "Kabondo Kasipul", "Karachuonyo", "Mbita"],
  "Isiolo": ["Isiolo North", "Isiolo South"],
  "Kajiado": ["Kajiado Central", "Kajiado East", "Kajiado North", "Kajiado South"],
  "Kakamega": ["Butere", "Khwisero", "Lurambi", "Malava", "Mumias East", "Mumias West"],
  "Kericho": ["Ainamoi", "Belgut", "Bureti", "Kipkelion East"],
  "Kiambu": ["Gatundu North", "Gatundu South", "Juja", "Kabete", "Kiambu Town"],
  "Kilifi": ["Ganze", "Kaloleni", "Kilifi North", "Magarini"],
  "Kirinyaga": ["Gichugu", "Kirinyaga Central", "Kirinyaga East", "Mwea"],
  "Kisii": ["Bobasi", "Bonchari", "Kitutu Chache North", "South Mugirango"],
  "Kisumu": ["Kisumu Central", "Kisumu East", "Kisumu West", "Nyakach"],
  "Kitui": ["Kitui Central", "Kitui East", "Kitui Rural", "Kitui South"],
  "Kwale": ["Kinango", "Lunga Lunga", "Matuga", "Msambweni"],
  "Laikipia": ["Laikipia East", "Laikipia North", "Laikipia West"],
  "Lamu": ["Lamu East", "Lamu West"],
  "Machakos": ["Kangundo", "Kathiani", "Machakos Town", "Mwala"],
  "Makueni": ["Kaiti", "Kibwezi East", "Kibwezi West", "Makueni"],
  "Mandera": ["Banissa", "Lafey", "Mandera East", "Mandera North"],
  "Marsabit": ["Laisamis", "Moyale", "North Horr", "Saku"],
  "Meru": ["Buuri", "Igembe Central", "Imenti Central", "Tigania East"],
  "Migori": ["Awendo", "Kuria East", "Kuria West", "Nyatike"],
  "Mombasa": ["Changamwe", "Jomvu", "Kisauni", "Mvita", "Nyali"],
  "Murang'a": ["Gatanga", "Kandara", "Kangema", "Kiharu"],
  "Nairobi": ["Dagoretti North", "Embakasi Central", "Kasarani", "Langata"],
  "Nakuru": ["Gilgil", "Kuresoi North", "Naivasha", "Nakuru Town East"],
  "Nandi": ["Aldai", "Chesumei", "Emgwen", "Mosop"],
  "Narok": ["Narok East", "Narok North", "Narok South", "Narok West"],
  "Nyamira": ["Borabu", "Kitutu Masaba", "North Mugirango", "West Mugirango"],
  "Nyandarua": ["Kinangop", "Mirangine", "Ndaragwa", "Ol Kalou"],
  "Nyeri": ["Kieni", "Mathira", "Mukurweini", "Nyeri Town"],
  "Samburu": ["Samburu East", "Samburu North", "Samburu West"],
  "Siaya": ["Alego Usonga", "Bondo", "Gem", "Rarieda", "Ugenya", "Ugunja"],
  "Taita Taveta": ["Mwatate", "Taveta", "Voi", "Wundanyi"],
  "Tana River": ["Bura", "Galole", "Garsen"],
  "Tharaka-Nithi": ["Chuka/Igambang'ombe", "Maara", "Tharaka"],
  "Trans Nzoia": ["Cherangany", "Endebess", "Kiminini", "Kwanza", "Saboti"],
  "Turkana": ["Loima", "Turkana Central", "Turkana East", "Turkana South"],
  "Uasin Gishu": ["Ainabkoi", "Kapseret", "Kesses", "Moiben", "Soy", "Turbo"],
  "Vihiga": ["Emuhaya", "Hamisi", "Luanda", "Sabatia", "Vihiga"],
  "Wajir": ["Eldas", "Tarbaj", "Wajir East", "Wajir North", "Wajir South", "Wajir West"],
  "West Pokot": ["Kapenguria", "Kacheliba", "Pokot South", "Sigor"]
};

document.getElementById('county').addEventListener('change', function () {
  const selectedCounty = this.value;
  const subcountySelect = document.getElementById('subcounty');
  subcountySelect.innerHTML = '<option value="">-- Select Subcounty --</option>';

  if (countySubcountyMap[selectedCounty]) {
    countySubcountyMap[selectedCounty].forEach(function (subcounty) {
      const option = document.createElement('option');
      option.value = subcounty;
      option.textContent = subcounty;
      subcountySelect.appendChild(option);
    });
  }
});
</script>
</body>
</html>
