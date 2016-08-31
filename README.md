BlueMediaConnector
==================
Prosty interfejs do obsługi API BlueMedia

Bilbioteka obsługuje 
- rozpoczynanie transakcji POST 
- interpretacja komunikatów ITN.

Jeśli zbierze się więcej osób zainteresowanych użyciem tej biblioteki, może stworzę jakąś dokumentację, testy jednostkowe,
obsługę innych funkcji API.
Na razie wystarcza na podstawowe potrzeby :)

Biblioteka oparta jest o bebechy zendframework (v3)

###I. Instalacja

```
composer require hopsey/blue-media-connector 
```

###II. API
#####1. Inicjowanie transakcji

```php
use BlueMediaConnector\Transaction\RedirectMode;

$bmService = BlueMediaConnector\Factory::build("http://url.bm.pl/url", 123456, "verySecretString");
$bmService->makeTransaction(
    new RedirectMode(), // typ wywolania: RedirectMode - przekierowanie, jest jeszcze wywołanie w tle, niezaimplemenotwane
    1.50,       // float - kwota
    "Wplata",   // opis
    1,          // gatewayId
    "PLN",      // currency
    "example@email.com"   // customer email
);
```
Wywołanie generuje zdarzenie ```preTransaction```, pod które można się podpinać. 
Do obsługi zdarzeń wykorzystywany jest moduł ```zendframework/zend-eventmanager```.

Przykład podpięcia się pod zdarzenie:

```php
use BlueMediaConnector\Event\PreTransactionEvent;

$bmService->getEventManager()->attach(PreTransactionEvent::EVENT_PRE_TRANSACTION, function (PreTransactionEvent $event) {
    /** @var BlueMediaConnector\Message\InitTransactionMessage */
    $message = $event->getParam('message');
    $message->amount; // 1.50
    $message->currency; // PLN
    
    // ... do stuff here. np zapis do bazy, etc.
});
```

Ewentualnie można podpiąć się obiektem implementującym ```Zend\EventManager\ListenerAggregateInterface```


#####2. ITN - Instant Transaction Notification

Obsługa zmiany statusu odbywa się w podłączonych do zdarzeń listenerach. Najpierw deifniujemy listener, następnie poprzez
wywołanie metody ```BmService::receiveItnResult($xmlContent)``` odpalamy event. Metoda sparsuje i przygotuje odpowiedź, sprawdza
także czy zgadza się nadesłany hash. Jeśli nie, wyrzucany jest wyjątek ```BlueMediaConnector\Message\InvalidHashException```. Na
samym końcu uruchamiany jest event.

```php
use BlueMediaConnector\Event\MessageReceivedEvent;

$transactionContent = base64_decode($_GET['transactions']);

$bmService->getEventManager()->attach(MessageReceivedEvent::EVENT_MESSAGE_RECEIVED, function (MessageReceivedEvent $event) {
    /** @var BlueMediaConnector\Message\ItnMessage */
    $message = $event->getParam('message');
    $messageArray = $message->toArray();
    $messageArray['transactions'][0]['status'] // pending, success, failure ...
    // ...
});

$bmService->receiveItnResult($transactionContent);
```
#####3. Dodatkowa konfiguracja

1. Algorytm hashowania

Domyślnie SHA256. Można zaimplementować własny, poprzez dodanie klasy implementującej ```BlueMediaConnector\ValueObject\Hash\Algo\AlgoInterface```.

```php
// PHP7
$bmService->getHashFactory()->setAlgo(new class implements AlgoInterface {
    public function hash($string)
    {
        return md5($string);
    }
});

```

2. Message transport

Domyślnie XML. Można zaimplementować dowolny format. 

```php
// PHP7
use BlueMediaConnector\Transport\TransportInterface;

$bmService->setTransport(new class implements TransportInterface {
    public function parse($content)
    {
        return json_decode($content);
    }
})
```

Copyright: Tomasz Chmielewski &lt;tom(malpa)hop.ventures&gt;
