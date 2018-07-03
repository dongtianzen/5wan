"""XLS -> json converter
first:
  $ pip install xlrd
then:
  $ cat in.xls
date, temp, pressure
Jan 1, 73, 455
Jan 3, 72, 344
Jan 7, 52, 100
convert:
  $ python xls_to_json.py in.xls Sheet1 out.json
finally:
  $ cat out.json
{
  'data': [
    {'date': 'Jan 1', 'temp': 73, 'pressure': 455},
    {'date': 'Jan 3', 'temp': 72, 'pressure': 344},
    {'date': 'Jan 7', 'temp': 52, 'pressure': 100},
  ]
}
"""

# cd web/modules/custom/python
# python3 xls_to_json_converter.py
import json
import sys

import xlrd

workbook = xlrd.open_workbook('sample.xls')
# worksheet = workbook.sheet_by_name(101)
worksheet = workbook.sheet_by_index(1)

# Index individual cells:
cell_c4 = worksheet.cell(7, 1).value
# Or you can use:
#cell_c4 = sh.cell(rowx=3, colx=2).value
print ('cell_c4')
print (cell_c4)

exit()

# Iterate through rows, returning each as a list that you can index:
for rownum in range(sh.nrows):
    print (sh.row_values(rownum))

# row
first_column = sh.row_values(0)

# If you just want the first column:
first_column = sh.col_values(0)
print (first_column)

# Serialize the list of dicts to JSON
output = json.dumps(cars_list)

# Write to file
with open('data.json', 'w') as f:
    f.write(output)

#
data = []
keys = [v.value for v in worksheet.row(0)]
for row_number in range(worksheet.nrows):
    if row_number == 0:
        continue
    row_data = {}
    for col_number, cell in enumerate(worksheet.row(row_number)):
        row_data[keys[col_number]] = cell.value
    data.append(row_data)

with open('result2.json', 'w') as json_file:
    json_file.write(json.dumps({'data': data}))
