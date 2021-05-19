const express = require('express')
const app = express()
const axios = require('axios')
require('dotenv').config()
app.set('view engine', 'ejs');

const bodyParser = require('body-parser')
app.use(bodyParser.urlencoded({ extended: true }))
app.use(express.static('public'))

let weather = ''
let errorString = ''

function ucwords (str) {
    return (str + '').replace(/^([a-z])|\s+([a-z])/g, function ($1) {
        return $1.toUpperCase();
    });
}

app.get('/', function(req, res){
    if(req.query.city) {
        let city = req.query.city
        let url = 'http://api.openweathermap.org/data/2.5/weather?q='+city+'&appid='+process.env.APIKEY

        axios.get(url)
        .then(function (response) {
            let weatherMainArray = Object.entries(response)
            weatherArray = weatherMainArray[5][1]
            if(weatherArray.cod==200){
                weatherArray.main.temp = weatherArray.main.temp - 273.15;
                if(weatherArray.weather[0].description == 'few clouds'){
                    weatherArray.weather[0].description = 'a '+ weatherArray.weather[0].description
                }
                weather = "The weather in "+ ucwords(req.query.city) +" is currently '"+ weatherArray.weather[0].description + "'. The temperature is "+ weatherArray.main.temp + " degree celcius. The humidity is "+ weatherArray.main.humidity+" % and the wind speed is "+ weatherArray.wind.speed+" meter/sec.";

                res.render('success', {weather: weather})
            } else {
                errorString = 'That city could not be found!'
                res.render('error', {errorString: errorString}) 
            }
        })
        .catch(function (error) {
            res.render('error', {errorString: errorString})
        })
    } else {
        res.render('home')
    }
})

app.listen(process.env.PORT || 3000)