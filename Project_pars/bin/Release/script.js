const puppeteer = require('puppeteer');
const fs = require('fs').promises;
const fse = require('fs-extra');
let fetch;
import('node-fetch').then(({default: importedFetch}) => {
  fetch = importedFetch;
});
const path = require('path');


const pathToImgFolder = './img';
async function resetImageFolder() {
    try {
      await fse.remove(pathToImgFolder); // Удаляем папку со всем её содержимым
      await fse.ensureDir(pathToImgFolder); // Создаём папку заново
      console.log('Папка Image была успешно очищена и создана заново');
    } catch (error) {
      console.error('Ошибка при работе с папкой Image:', error);
    }
  }
  async function downloadImage(url, outputPath) {
    const response = await fetch(url);
    const buffer = await response.buffer();
    await fs.writeFile(outputPath, buffer);
  }
  
 /* async function loadCredentials() {
    try {
        const data = await fs.readFile('auth.json', 'utf8');
        const credentials = JSON.parse(data); 
        return credentials;
    } catch (error) {
        console.error('Ошибка при чтении файла auth.json:', error);
        throw error;
    }
}
*/
async function loadUrlsFromFile(filename) {
    const fileContent = await fs.readFile(filename, 'utf8');
    const urls = JSON.parse(fileContent).urls;
    return urls;
}
    async function scrapeProductData(productUrl) {
      const browser = await puppeteer.launch({ headless: false });
      const page = await browser.newPage();
        await page.goto('https://sklep.martextruck.pl/');
    
    // Замените на ваши учетные данные
    //const logPare = await loadCredentials();
    const username = "48350";
    const password = "123456789S";
    
        await page.type('#ctl00_box_3_tbUserId', username);
        await page.type('#ctl00_box_3_tbPassword', password);


        try {
          // Ищем кнопку согласия/закрытия и кликаем по ней
          // Замените селектор на актуальный для вашего сайта
          const consentButtonSelector = 'button[id="CybotCookiebotDialogBodyLevelButtonLevelOptinAllowAll"]'; // Примерный селектор
          const buttLogin = 'button[id="ctl00_box_3_btnLogin"]';
          
          await page.waitForSelector(consentButtonSelector, { timeout: 5000 }); // Подождите, пока кнопка не станет доступна
          await page.click(consentButtonSelector);
          await page.waitForSelector(buttLogin, { timeout: 5000 }); // Подождите, пока кнопка не станет доступна
          
      } catch (error) {
          console.log('Всплывающее окно с уведомлением о cookies не найдено, продолжение скрапинга...');
      }
        

      await page.evaluate(() => {
        document.querySelector('input[id="ctl00_box_3_btnLogin"]').click();
    });
        await page.waitForNavigation();
        await page.select('select[name="ctl00$box_5$changeclientprice1$ddlChangeClientPrice"]', '1');
        await page.waitForNavigation();
        await page.goto(productUrl + "?lang=en", { waitUntil: 'networkidle0' });
        await page.waitForSelector('#ctl00_box_8_abc_changelanguage1_rptLanguages_ctl01_HyperLink1', { timeout: 20000 });
await Promise.all([
    page.click('#ctl00_box_8_abc_changelanguage1_rptLanguages_ctl01_HyperLink1'),
    page.waitForNavigation({ waitUntil: 'networkidle0' }),
]);

        

        
    
        const productData = await page.evaluate((productUrl) => {
            const urlParts = productUrl.split('-');
            const productCodeMatch = productUrl.match(/\/(\d+)-/);
            const productCode = productCodeMatch ? productCodeMatch[1] : '';

            const name = document.querySelector('.ofpName') ? document.querySelector('.ofpName').innerText + ': ' + productCode : '';
            let description = name + ' ' + (document.querySelector('.ofpProducerName') ? document.querySelector('.ofpProducerName').innerText : '');

    // Собираем данные из таблицы partmanufacturercodescontrol
    const partManufacturerCodes = Array.from(document.querySelectorAll('.partmanufacturercodescontrol tr')).map(tr => {
        const cells = tr.querySelectorAll('td');
        if(cells.length > 0) {
            const manufacturer = cells[0].innerText;
            const code = cells[1].innerText;
            return `${manufacturer} - ${code}`;
        }
    }).filter(Boolean).join('; ');

    const codes = Array.from(document.querySelectorAll('.partmanufacturercodescontrol tr')).map(tr => {
        const cells = tr.querySelectorAll('td');
        if(cells.length > 0) {
            const manufacturer = cells[0].innerText;
            const code = cells[1].innerText;
            return `${code}`;
        }
    }).filter(Boolean).join(', ');


    // Добавляем информацию из таблицы в описание
    if (partManufacturerCodes) {
        description += `; OE: ${partManufacturerCodes}`;
    }
                const categories = document.querySelector('.ofpProducerName') ? document.querySelector('.ofpProducerName').innerText : '';
            const regularPrice = document.querySelector('.ofpRetailGrossPrice span[itemprop="price"]') ? document.querySelector('.ofpRetailGrossPrice span[itemprop="price"]').innerText : '';
            const sku = document.querySelector('.artvalue[itemprop="productID"]') ? document.querySelector('.artvalue[itemprop="productID"]').innerText : '';
            const imageUrl = document.querySelector('#ctl00_pagecontext_articleimagecontrol1_PanelLargeImg img') ? document.querySelector('#ctl00_pagecontext_articleimagecontrol1_PanelLargeImg img').src : '';
            const stock = 1; // Always 1 for demonstration
            const shortDescription = 'delivery time 3-4 days';
            
    
            return {
                name,
                description,
                categories,
                regularPrice,
                sku,
                imageUrl,
                stock,
                shortDescription,
                oe: productCode,
                manufacturer: document.querySelector('.ofpProducerName') ? document.querySelector('.ofpProducerName').innerText : '',
                codes
            };
        }, productUrl);
        const imageUrls = await page.evaluate(() => {
            const images = [];
            document.querySelectorAll("div.smGenCont a, div#ctl00_pagecontext_articleimagecontrol1_PanelLargeImg img").forEach((img) => {
              const imgSrc = img.getAttribute('href') || img.getAttribute('src');
              if (imgSrc) {
                images.push(new URL(imgSrc, window.location.origin).href);
              }
            });
            return images;
          });
          
          // Перед скачиванием изображений убедитесь, что папка img очищена и готова к использованию
          await resetImageFolder();
          
          // Скачивание изображений
          for (const [index, imageUrl] of imageUrls.entries()) {
            const imagePath = `${pathToImgFolder}/image_${index}.jpg`; // Назначаем имя файла
            await downloadImage(imageUrl, imagePath);
            console.log(`Image downloaded: ${imagePath}`);
          }
        console.log('Product Data:', productData);
    
        // Проверка существования SKU в вашей базе данных (псевдокод/логика)
        // if (checkSKUExists(productData.sku)) {
        //     console.error('Product already exists');
        // } else {
        //     // Логика сохранения данных о продукте
        // }
    
        await browser.close();

    return productData; // Возвращаем данные о продукте
    }
    async function saveProductDataToFile(productData, filename) {
      const fileContent = JSON.stringify(productData, null, 2);
      await fs.writeFile(filename, fileContent, 'utf8');
  }
  
  async function main() {
      const urls = await loadUrlsFromFile('urls.json');
      for (const url of urls) {
          try {
              const productData = await scrapeProductData(url);
              await saveProductDataToFile(productData, 'result.json');
              console.log(`Data for ${url} has been saved.`);
          } catch (error) {
              console.error(`An error occurred while processing ${url}: ${error}`);
          }
      }
  }
  
  main().catch(console.error);
    
    // Пример использования функции
