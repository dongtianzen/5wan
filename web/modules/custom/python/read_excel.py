# cd web/modules/custom/python
# python3 read_excel.py

#

import pandas as pd

workbook_path = 'sample.xls'
excel_content = pd.read_excel(workbook_path)

print (excel_content)
