<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Thermometer App</title>
</head>
<body>
  <button id="connectButton">Connect to Thermometer</button>
  <div id="temperatureDisplay">Temperature: N/A</div>

  <script>
    document.getElementById('connectButton').addEventListener('click', async () => {
      try {
        const device = await navigator.bluetooth.requestDevice({
      filters: [{ services: ['00001234-0000-1000-8000-00805f9b34fb'] }], // Replace with the actual UUID
    });

        const server = await device.gatt.connect();
        const service = await server.getPrimaryService('temperature_service_uuid');
        const characteristic = await service.getCharacteristic('temperature_characteristic_uuid');

        characteristic.addEventListener('characteristicvaluechanged', (event) => {
          const temperature = event.target.value.getFloat32(0, true);
          document.getElementById('temperatureDisplay').innerText = `Temperature: ${temperature} °C`;
        });

        await characteristic.startNotifications();
      } catch (error) {
        console.error('Error connecting to thermometer:', error);
      }
    });
  </script>
</body>
</html>
