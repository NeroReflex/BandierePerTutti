# BandierePerTutti

Questa webapp è una dimostrazione del framework [Gishiki](https://github.com/NeroReflex/Gishiki) e di quanto
sia facile e intuitivo da usare.

## Installazione
L'installazione si divide in quattro passaggi:

   1. Download dell'applicazione (tramite git o una release in .zip o tar.gz)
   2. php composer.phar install
   3. upload di tutto nello spazio di hosting
   4. modifica del tokenID in application/settings.json o settaggio di TOKEN_ID nella configurazione del server
   
Se lo "spazio di hosting" è un VPS e avete eseguito i primi due passaggi nella directory esposta
ad apache vi sarete risparmiati il passo 3!

## Utilizzo
Basta eseguire una richiesta GET /look/nome_bandiera per controllare lo stato della bandiera
chiamata nome_bandiera.

un richiesta POST a /set/nome_bandiera o /clear/nome_bandiera sarà necessaria a far cambiare
lo stato di una bandiera e a __crearla__ nel caso non esista una bandiera con quel nome.

Per limitare i diritti di chi può cambiare lo stato di una bandiera nell'eseguire una richiesta
è necessario includere il tokenID impostato al punto 4.

Tale tokenID sarà __UNIVOCO__ per __TUTTE__ le bandiere!

esempio di richiesta:

```
POST https://bandiereperutti.herokuapp.com/clear/uffici_aperti
Accept: */*
Content-Length: 47
Content-Type: application/json
User-Agent: topsecret

{
"tokenID": "************************"
}
```

Questo porterà a false lo stato della bandiera chiamata uffici_aperti, infatti una successiva richiesta
di stato:

```
GET https://bandiereperutti.herokuapp.com/look/uffici_aperti
Accept: */*
User-Agent: topsecret
```

otterrà una risposta HTTP o HTTPS con il seguente corpo (body):

```
{
"name": "uffici_aperti",
"status": false
}
```
