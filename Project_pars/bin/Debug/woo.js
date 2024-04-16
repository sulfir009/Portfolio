const WooCommerceRestApi = require("@woocommerce/woocommerce-rest-api").default;
const fs = require('fs').promises;
const { exec } = require('child_process');
const path = require('path');
(async () => {
    const logWC = await fs.readFile("authWC.json", "utf8");
    const logParseWC = JSON.parse(logWC);
    const logWP = await fs.readFile("authWP.json", "utf8");
    const logParseWP = JSON.parse(logWP);

    const WooCommerce = new WooCommerceRestApi({
        url: 'https://spares24.eu/',
        consumerKey: logParseWC.Username,
        consumerSecret: logParseWC.Password,
        version: 'wc/v3'
    });

    // Аутентификационные данные для WordPress
    const WPUsername = logParseWP.Username;
    const WPPassword = logParseWP.Password;

// Функция для загрузки изображения и обновления его метаданных
// Функция для загрузки изображения и обновления его метаданных с учетом порядкового номера
const uploadAndUpdateImage = async (imagePath, oeCode, index) => {
  const fileContent = await fs.readFile(imagePath);
  // Изменение имени файла в зависимости от порядкового номера изображения
  const filename = index === 1 ? `image_${path.basename(imagePath)}` : `image_${index}_${path.basename(imagePath)}`;
  const uploadUrl = 'https://spares24.eu/wp-json/wp/v2/media';
  
  // Загрузка файла
  const uploadResponse = await fetch(uploadUrl, {
      method: 'POST',
      headers: {
          'Authorization': 'Basic ' + Buffer.from(`${WPUsername}:${WPPassword}`).toString('base64'),
          'Content-Disposition': `attachment; filename="${filename}"`,
          'Content-Type': 'image/jpeg'
      },
      body: fileContent
  });
  
  const uploadData = await uploadResponse.json();
  
  // Формирование метаданных с учетом порядкового номера
  const metaData = {
      title: index === 1 ? oeCode : `${oeCode}_${index}`,
      alt_text: index === 1 ? oeCode : `${oeCode}_${index}`,
      caption: index === 1 ? ` ${oeCode}` : ` ${index}_${oeCode}`,
      description: index === 1 ? `${oeCode}.` : `${index}_${oeCode}`
  };

  const updateUrl = `https://spares24.eu/wp-json/wp/v2/media/${uploadData.id}`;
  const updateResponse = await fetch(updateUrl, {
      method: 'POST',
      headers: {
          'Authorization': 'Basic ' + Buffer.from(`${WPUsername}:${WPPassword}`).toString('base64'),
          'Content-Type': 'application/json'
      },
      body: JSON.stringify(metaData)
  });

  const updateData = await updateResponse.json();
  console.log('Metadata updated:', updateData);
  return updateData.id; // Возвращаем ID обновленного изображения
};

function closeCmdWindow() {
  exec('taskkill /F /IM cmd.exe', (err, stdout, stderr) => {
    if (err) {
      console.error(`Ошибка при закрытии окна cmd: ${err}`);
      return;
    }
    console.log('Окно cmd закрыто');
  });
}

const uploadImagesFromDirectoryAndUpdate = async (directoryPath, oeCode) => {
  const files = await fs.readdir(directoryPath);
  const imageIds = [];

  let index = 1; // Начинаем с 1
  for (const file of files) {
    
    const filePath = path.join(directoryPath, file);
    // Передаем текущий индекс как часть имени файла
    const imageId = await uploadAndUpdateImage(filePath, oeCode, index);
    imageIds.push({ id: imageId });
    index++; // Увеличиваем индекс для следующего файла
  }
  
  return imageIds;
};



async function ensureTagsExist(codes, sku) {
  const tagIds = [];

  // Если нет кодов, добавляем тег с SKU
  if (!codes || codes.length === 0) {
    try {
      let newTag = await WooCommerce.post("products/tags", { name: sku });
      if (newTag.data && newTag.data.id) {
        console.log(`Создан тег для SKU: ${sku}`);
        return [{ id: newTag.data.id }]; // Возвращаем массив с одним ID тега
      } else {
        console.error(`Не удалось создать тег для SKU: ${sku}`);
        return []; // Возвращаем пустой массив, если создать тег не удалось
      }
    } catch (error) {
      console.error(`Ошибка при создании тега для SKU: ${error}`);
      return []; // Возвращаем пустой массив в случае ошибки
    }
  }

  for (const code of codes) {
    if (code === '0005458713') {
      console.log(`Пропуск добавления тега: ${code}`);
      continue;
    }

    try {
      // Проверяем существование тега
      let tagResponse = await WooCommerce.get("products/tags", { search: code });
      let tagId;

      if (tagResponse.data.length === 0) {
        // Создаем новый тег, если он не найден
        let newTag = await WooCommerce.post("products/tags", { name: code });
        if (newTag.data && newTag.data.id) {
          tagId = newTag.data.id;
          tagIds.push({ id: tagId });
        } else {
          console.error(`Не удалось создать тег ${code}`);
        }
      } else {
        tagId = tagResponse.data[0].id;
        tagIds.push({ id: tagId });
      }
    } catch (error) {
      console.error(`Ошибка при работе с тегом ${code}:`, error);
    }
  }

  return tagIds;
}
function appendProductInfoToFile(sku, stock, name, filePath) {
  const line = `${sku}; ${stock}; ${name}\n`; // Форматируем строку для записи
  fs.appendFileSync(filePath, line, 'utf8'); // Дописываем строку в файл
}


async function ensureCategoryExists(categoryName) {
  try {
    const response = await WooCommerce.get("products/categories", { search: categoryName });
    const categories = response.data;
    if (categories.length === 0) {
      const newCategoryResponse = await WooCommerce.post("products/categories", { name: categoryName });
      return newCategoryResponse.data.id;
    } else {
      return categories[0].id;
    }
  } catch (error) {
    console.error("Ошибка при работе с категориями:", error);
    throw error;
  }
}
async function getTagIdsByCodes(codes) {
    // Здесь должна быть реализация получения ID тегов по кодам
    return codes.map(code => ({ id: Math.floor(Math.random() * 1000) })); // Пример реализации
  }

  async function createOrUpdateProduct(filename) {
    try {
      const jsonData = await fs.readFile(filename, 'utf8');
      const productData = JSON.parse(jsonData);
      const codesArray = productData.codes ? productData.codes.split(',').map(code => code.trim()) : [];
    // Фильтрация codesArray, исключая '0005458713'
    const filteredCodes = codesArray.filter(code => code !== '0005458713');
    // Передача отфильтрованного массива и SKU в ensureTagsExist
    const tagIds = await ensureTagsExist(filteredCodes, productData.sku);
  
      // Проверяем существование продукта по SKU
      const response = await WooCommerce.get("products", { sku: productData.sku });
      const existingProduct = response.data.length > 0 ? response.data[0] : null;
      const imagesDirectoryPath = path.join(__dirname, 'img');
      var atr;
     
      if (productData.oe == null){
        atr = productData.sku;
      }else{
        atr = productData.oe;
      }
      const imagesIds = await uploadImagesFromDirectoryAndUpdate(imagesDirectoryPath, atr);
  
      // Категория
      const categoryId = await ensureCategoryExists(productData.categories);
  
      // Преобразуем цену
      const formattedPrice = productData.regularPrice.replace(',', '.');
      const codesOptions = productData.codes ? productData.codes.split(',').map(code => String(code).trim()) : [];
  
  
      // Формируем данные продукта
      const productPayload = {
          name: productData.name,
          type: "simple",
          regular_price: formattedPrice,
          description: productData.description,
          short_description: productData.shortDescription,
          categories: [{ id: categoryId }],
          sku: productData.sku,
          manage_stock: true,
          stock_quantity: productData.stock,
          images: imagesIds.map(({ id }) => ({ id })),
          attributes: [
            {
              name: "Manufacturer",
              options: [String(productData.manufacturer)], // Явное приведение к строке
              visible: true,
              variation: false
            },
            {
              name: "OE",
              options: [String(productData.oe)], // Явное приведение к строке
              visible: true,
              variation: false
            },
            {
              name: "OEM",
              options: codesOptions.map(option => String(option)), // Явное приведение каждого элемента к строке
              visible: true,
              variation: false
            }
          ],
          tags: tagIds.map(tag => ({id: tag.id})) // Убедитесь, что теги формируются корректно
        };
        appendProductInfoToFile(productData.sku, productData.stock, productData.name, 'product.txt');
  
      if (existingProduct) {
        // Обновляем существующий продукт
        console.log(`Товар с таким sku уже существует. ID: ${existingProduct.id}`);
        //const updatedProduct = await WooCommerce.put(`products/${existingProduct.id}`, productPayload);
        //console.log('Продукт успешно обновлен', updatedProduct.data);
      } else {
        // Создаем новый продукт
        console.log('Создание нового продукта');
        const createdProduct = await WooCommerce.post("products", productPayload);
        console.log('Продукт успешно создан', createdProduct.data);
      }
    } catch (error) {
      console.error('Ошибка:', error.response ? error.response.data : error.message);
    }
  }



  try {
    await createOrUpdateProduct('result.json');
    console.log('Скрипт успешно выполнен');
    process.exit(0); // Успешное завершение
    closeCmdWindow();
  } catch (error) {
    console.error('Error:', error);
    process.exit(1); // Завершение с ошибкой
    closeCmdWindow();
  }
})();
