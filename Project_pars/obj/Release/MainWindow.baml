   M S B A M L   `   `   `  ����   Project_pars    Project_pars.MainWindow   \ XPresentationFramework, Version=4.0.0.0, Culture=neutral, PublicKeyToken=31bf3856ad364e35R NWindowsBase, Version=4.0.0.0, Culture=neutral, PublicKeyToken=31bf3856ad364e35W SPresentationCore, Version=4.0.0.0, Culture=neutral, PublicKeyToken=31bf3856ad364e35D 9http://schemas.microsoft.com/winfx/2006/xaml/presentation    R NSystem.Xaml, Version=4.0.0.0, Culture=neutral, PublicKeyToken=b77a5c561934e089:x,http://schemas.microsoft.com/winfx/2006/xaml     Aav2http://schemas.microsoft.com/expression/blend/2008     Jmc;http://schemas.openxmlformats.org/markup-compatibility/2006       � Title$   Product Information Parser��$	��700��$	��700�� � 
ResizeMode$ CanResizeWithGrip=� � SizeToContent$ WidthAndHeight=�.���  � ColumnDefinitions �� $��4* ��� $	��31* ��� $	��83* ��� $
��188* �.+��� $
��Left=�$��30,6,0,0q�$
��Wrap=�$��Авторизация��$	��Top=�$��2��$��20(�$��1���� 
���   �$��1q����	#FF8D8989$��0,34,1,0q�$��3���� -    ��Name$ textBoxUsername��$��1��$��
23,93,55,0q� �� TextWrapping$
 Wrap=�$��TextBox��$��2��$	��Top=��� -   $ passwordBox��$��1��$��23,133,55,0q�$
 Wrap=�$��TextBox��$	��Top=�$��2���� -   $��
Логин��$��36,185,67,0q�$	��Top=�$��2��$��1���� $
��Left=�$��2,96,0,0q�$
��Wrap=�$��Лог��$	��Top=�$��9(�$��42��$��1���� $
��Left=�$��	2,136,0,0q�$
��Wrap=�$��Пас.��$	��Top=�$��9(�$��42��$��1���� 
���   �$��1q�$��3�����	#FFD9D6D6$��0,34,0,0q�$	��Top=��� -   $ 
urlTextBox��$��3��$��80,11,155,0q�$	��URL��$	��Top=�$ NoWrap=�" �� VerticalScrollBarVisibility$ Disabled=��� $��3��$��URL Content��$��0,6,0,0q�$	��Top=�$��89��$
��Left=��� $��4��$��Name of Product:��$��5,37,0,0q�$	��Top=��� -   $ textBoxProductName��$��4��$��
113,41,0,0q�$	��Top=��� $��4��$��Description:��$
��Left=�$	��Top=�$��	10,66,0,0q��� -   $ textBoxDescription��$��4��$��
113,70,0,0q�$	��Top=��� $��4��$��Categories:��$
��Left=�$	��Top=�$��	10,96,0,0q��� -   $ textBoxCategories��$��4��$��
113,99,0,0q�$	��Top=��� $��4��$��Regular Price:��$
��Left=�$	��Top=�$��
10,126,0,0q��� -   $ textBoxPrice��$��4��$��113,130,0,0q�$	��Top=��� $��4��$
��Sku:��$
��Left=�$	��Top=�$��
10,156,0,0q��� -	   $ 
textBoxSKU��$��4��$��113,160,0,0q�$	��Top=��� $��4��$��Stock:��$
��Left=�$	��Top=�$��
10,187,0,0q��� -
   $ textBoxStock��$��4��$��113,191,0,0q�$	��Top=��� $��4��$��Short Description:��$
��Left=�$	��Top=�$��
11,217,0,0q��� -   $ textBoxShortDescription��$��4��$��113,222,0,0q�$	��Top=��� $��4��$	��OE:��$
��Left=�$	��Top=�$��
12,260,0,0q��� -   $ 	textBoxOE��$��4��$��116,263,0,0q�$	��Top=�$��20���� $��4��$��Manufacturer:��$
��Left=�$	��Top=�$��
10,316,0,0q��� -   $��Отправить��$��Center=�$��	0,631,0,0q�$	��Top=�$	��120��$��3���� -    ��Name$ 	ImageList��$��80,392,10,173q�$��3���� -   $��Спарсить��$��Right=�$��0,9,77,0q�$	��Top=�$��3��
��� � �$��73�� J� RenderTransformOrigin$ -0.116,0.894&��� $��3��$��Image:��$
��Left=�$	��Top=�$��
12,385,0,0q��� $"��Укажите процен:��$
��Left=�$	��Top=�$��	4,498,0,0q�$��3��$	��108���� $ ��Итоговая цена:��$
��Left=�$	��Top=�$��	4,529,0,0q�$��3��$	��108���� -   $ Protsent��$��2��$��47,502,10,0q�$	��Top=��� -   $ ResultTextBox��$��2��$��47,533,10,0q�$	��Top=��� -   $ Manufacturer��$��4��$��113,320,0,0q�$	��Top=��� $��WordPress ключи��$	��Top=�$��
50,230,0,0q�$��2��$��1���� $��Woocomerce ключи��$	��Top=�$��
50,342,0,0q�$��2��$��1���� -   $ logWP��$��1��$��14,255,17,0q�$	��Top=�$ NoWrap=�$ Disabled=�$��2���� -   $ passWP��$��1��$��14,278,17,0q�$	��Top=�$ NoWrap=�$ Disabled=�$��2���� -   $��Записать��$��50,305,53,0q�$	��Top=�$��2��$��1���� -   $ logWC��$��consumerKey��$��1��$��14,373,17,0q�$	��Top=�$ NoWrap=�$ Disabled=�$��2���� -   $ passWC��$��consumerSecret��$��1��$��14,396,17,0q�$	��Top=�$ NoWrap=�$ Disabled=�$��2���� -   $��Записать��$��50,419,53,0q�$	��Top=�$��2��$��1���� -   $��Очистить��$��Right=�$��0,9,0,0q�$	��Top=�$��3��
�������$ -0.116,0.894&�$��72��