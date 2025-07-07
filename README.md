# C10 Spam Classifier Bundle

**C10 Spam Classifier API Bundle** je jednoduchý Symfony modul, který umožňuje posílat textové zprávy do vašeho FastAPI antispam klasifikátoru a vracet výsledek (spam / ham).  
Podporuje konfiguraci URL a zdroje zprávy přes `.env` proměnné.

---

## 📦 Instalace

1️⃣ Přidejte svůj bundle do projektu přes Composer (například z GitHubu):

```
composer config repositories.c10_spam vcs https://github.com/jesus_praha/c10-spam-bundle.git
composer require c10/spam-bundle:dev-main
```

Pokud používáte `composer.json` ručně:
```json
"repositories": [
  {
    "type": "vcs",
    "url": "https://github.com/c10/spam-bundle.git"
  }
]
```

---

## ⚙️ Konfigurace

### 1) Přidejte do `.env` nebo `.env.local`:

```
###> C10 Spam ###
SPAM_API_URL="https://api.example.com"
SPAM_API_SOURCE="contact_form"
###< C10 Spam ###
```

### 2) Vytvořte soubor `config/packages/c10_spam.yaml`:

```yaml
c10_spam:
  api_url: '%env(resolve:SPAM_API_URL)%'
  api_source: '%env(resolve:SPAM_API_SOURCE)%'
```

### 3) Přidejte alias do `config/services.yaml`:

```yaml
services:
    C10\SpamBundle\Service\SpamClassifierApi: '@c10_spam.classifier'
```

Tím zajistíte, že služba `SpamClassifierApi` se bude správně autowirovat.

---

## ✅ Použití

V jakémkoliv Symfony kontroleru nebo jiné službě můžete injektovat službu:

```php
use C10\SpamBundle\Service\SpamClassifierApi;

public function submit(SpamClassifierApi $classifier)
{
    $result = $classifier->classify('Toto je testovací zpráva.');
    dump($result);
    // Např. ['label' => 'spam', 'id' => 42]

    if ($result['label'] === 'spam') {
        // Udělej např. redirect nebo error
    }

    // Zpracuj validní zprávu...
}
```

---

## 🔗 API struktura

- HTTP `POST` na `/predict` (na FastAPI backendu)
- Request JSON:
  ```json
  {
    "text": "Nějaká zpráva...",
    "source": "contact_form"
  }
  ```

- Response JSON:
  ```json
  {
    "label": "spam",
    "id": 42
  }
  ```

---

## 🗂️ Složení balíčku

- `src/Service/SpamClassifierApi.php` – služba pro volání FastAPI
- `src/DependencyInjection/Configuration.php` – definuje config schéma
- `src/DependencyInjection/C10SpamExtension.php` – načítá nastavení a registruje službu
- `C10SpamBundle.php` – samotný bundle

---

## 🧩 Minimální požadavky

- PHP >= 7.4
- Symfony 5.4 nebo 6.x
- `symfony/http-client`

Pokud používáte starší PHP, nastavte `platform.php` ve svém `composer.json`:
```json
"config": {
  "platform": {
    "php": "7.4"
  }
}
```

---

## 🔒 Bezpečnost

- Ujistěte se, že komunikace s vaším FastAPI serverem probíhá přes HTTPS.
- `SPAM_API_URL` a `SPAM_API_SOURCE` doporučujeme nastavit pro každé prostředí zvlášť přes `.env.local` nebo systémové proměnné.

---

## 🤝 Přispívání

Pull Requesty, hlášení bugů i feature requesty vítáme!  
Stačí forknout, udělat úpravy a poslat PR.

---

## 📝 Licence

MIT License – používejte volně i pro komerční projekty.

---

**C10 Group s.r.o.**

📧 [info@c10.cz](mailto:info@c10.cz)  
🌐 [https://c10.cz](https://c10.cz)
