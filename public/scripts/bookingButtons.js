const buttonContainer = document.getElementById('booking-button')
const noonBooking = document.getElementById('noon-booking')
const eveningBooking = document.getElementById('evening-booking')
const buttonsXhr = new XMLHttpRequest()
let hoursResult

function zero(number) {
    return (number < 10) ? ('0' + number) : number
}

function hoursHandler() {
    if (noonBooking) {
        buttonsXhr.open('GET', '/noon_booking_hours', true)
        buttonsXhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest')
        buttonsXhr.addEventListener('readystatechange', () => {
            if (buttonsXhr.readyState === 4 && buttonsXhr.status === 200) {
                hoursResult = buttonsXhr.response
                const noonHourData = JSON.parse(hoursResult)
                for (let i = noonHourData[0]; i <= noonHourData[1]; i++) {
                    for (let j = 0; j <= 3; j++) {
                        if (i < (noonHourData[1] - 1)) {
                            let btn = document.createElement('button')
                            btn.setAttribute('class', 'btn btn-ls btn-primary m-2')
                            btn.setAttribute('name', 'submit')
                            btn.setAttribute('type', 'submit')
                            btn.innerText = i + ':' + zero(j * 15)
                            btn.setAttribute('value', btn.innerText)
                            btn.setAttribute('id', btn.innerText + '_submit')
                            buttonContainer.append(btn)
                        } else if (i === (noonHourData[1] - 1)) {
                            let btn = document.createElement('button')
                            btn.setAttribute('class', 'btn btn-ls btn-primary m-2')
                            btn.setAttribute('type', 'submit')
                            btn.setAttribute('name', 'submit')
                            btn.innerText = i + ':00'
                            btn.setAttribute('value', btn.innerText)
                            btn.setAttribute('id', btn.innerText + '_submit')
                            buttonContainer.append(btn)
                            break
                        }
                    }
                }
            }
        })
        buttonsXhr.send()
    } else if (eveningBooking) {
        buttonsXhr.open('GET', '/evening_booking_hours', true)
        buttonsXhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest')
        buttonsXhr.addEventListener('readystatechange', () => {
            if (buttonsXhr.readyState === 4 && buttonsXhr.status === 200) {
                hoursResult = buttonsXhr.response
                const eveningHourData = JSON.parse(hoursResult)
                for (let i = eveningHourData[0]; i <= eveningHourData[1]; i++) {
                    for (let j = 0; j <= 3; j++) {
                        if (i < (eveningHourData[1] - 1)) {
                            let btn = document.createElement('button')
                            btn.setAttribute('class', 'btn btn-ls btn-primary m-2')
                            btn.setAttribute('name', 'submit')
                            btn.setAttribute('type', 'submit')
                            btn.innerText = i + ':' + zero(j * 15)
                            btn.setAttribute('value', btn.innerText)
                            btn.setAttribute('id', btn.innerText + '_submit')
                            buttonContainer.append(btn)
                        } else if (i === (eveningHourData[1] - 1)) {
                            let btn = document.createElement('button')
                            btn.setAttribute('class', 'btn btn-ls btn-primary m-2')
                            btn.setAttribute('type', 'submit')
                            btn.setAttribute('name', 'submit')
                            btn.innerText = i + ':00'
                            btn.setAttribute('value', btn.innerText)
                            btn.setAttribute('id', btn.innerText + '_submit')
                            buttonContainer.append(btn)
                            break
                        }
                    }
                }
            }
        })
        buttonsXhr.send()
    }
}

window.addEventListener('DOMContentLoaded', hoursHandler)