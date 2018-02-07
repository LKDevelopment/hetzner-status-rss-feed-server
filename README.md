## Hetzner Status RSS Feed Server

Dieser Server sorgt für die Push Notifications in der Hetzner Cloud Mobile App.

Ebenso stellt er kostenfrei alle Statusmeldungen der Hetzner Online GmbH als JSON String zur Verfügung:
https://hetzner-status.lkdev.co/api/hetzner-status

Sollten Sie diesen Service selbst hosten wollen müssen Sie die Anwendung wie folgt installieren:
```bash
git clone https://github.com/LKDevelopment/hetzner-status-rss-feed-server
cd hetzner-status-rss-feed-server
nano .env // .env Datei bearbeiten und die Zugangsdaten zur Datenbank eintragen
php artisan migrate
```

Push Notifications werden über den kostenfreien Dienst ["OneSignal"](https://onesignal.com/) versendet. 