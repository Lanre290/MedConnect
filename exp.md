--
SLIDE 1: Introduction
 **Title:** Understanding Array Operations in Python
 **Content:**- Overview of array operations- Explanation of the provided Python code--
### SLIDE 2: Initial Array
 **Title:** Initial Array
 **Content:**
 ```python
 array = [10, 20, 30, 50, 70, 60, 40, 90, 100, 80]
 ```- This is the initial array used in the code.--
### SLIDE 3: Main Function
 **Title:** Main Function
 **Content:**
 ```python
 def main():
 global array
 print(array)
 ```- The `main` function prints the initial array.--
### SLIDE 4: Adding Elements
 **Title:** Adding Elements
 **Content:**
 ```python
 array.append(10) # Adds 10 to the end of the array
 array.insert(0, 20) # Adds 20 to the beginning of the array
 ```- `append(10)`: Adds 10 to the end.- `insert(0, 20)`: Adds 20 to the beginning.
--
### SLIDE 5: Removing Elements
 **Title:** Removing Elements
 **Content:**
 ```python
 array.pop() # Removes the last element
 array.pop(0) # Removes the first element
 ```- `pop()`: Removes the last element.- `pop(0)`: Removes the first element.--
### SLIDE 6: Accessing Elements
 **Title:** Accessing Elements
 **Content:**
 ```python
 print("The first element is:", array[0]) # Prints the first element
 print("The last element is:", array[-1]) # Prints the last element
 ```- Accessing the first and last elements of the array.--
### SLIDE 7: Array Length
 **Title:** Array Length
 **Content:**
 ```python
 print("The length of the array is:", len(array))
 ```- Prints the length of the array.--
### SLIDE 8: Get Element Function
 **Title:** Get Element Function
 **Content:**
 ```python
 def getElement(index):
 global array
 if len(array) >= index:
 print(f"The element at index {index} is:", array[index- 1])
 else:
print("Array doesn't have a fifth element.")
 ```- Retrieves an element at a given index.--
### SLIDE 9: Search Function
 **Title:** Search Function
 **Content:**
 ```python
 def search(search_text):
 global array
 for i, item in enumerate(array):
 if item == search_text:
 print(f"Element {item} found at index: {i}")
 return item
 return None
 ```- Searches for an element in the array.--
### SLIDE 10: Insert Function
 **Title:** Insert Function
 **Content:**
 ```python
 def insert(index, item):
 global array
 array.insert(index, item)
 print("Your updated array is:", array)
 ```- Inserts an element at a specified index.--
### SLIDE 11: Delete Function
 **Title:** Delete Function
 **Content:**
 ```python
 def delete_in_array(index):
 global array
 if 0 <= index < len(array):
 array.pop(index)
 print("Here is your edited array:", array)
 else:
print("Invalid index.")
 ```- Deletes an element at a specified index.--
### SLIDE 12: Traverse Array
 **Title:** Traverse Array
 **Content:**
 ```python
 def traverseArray():
 global array
 for i, item in enumerate(array):
 print(f"Element {i} is: {item}")
 ```- Traverses and prints each element in the array.--
### SLIDE 13: Bubble Sort
 **Title:** Bubble Sort
 **Content:**
 ```python
 def bubbleSort():
 global array
 n =len(array)
 for i in range(n):
 for j in range(0, n-i-1):
 if array[j] > array[j+1]:
 array[j], array[j+1] = array[j+1], array[j]
 print(f"your sorted array is: ", array)
 ```- Sorts the array using the bubble sort algorithm.--
### SLIDE 14: Clear Array
 **Title:** Clear Array
 **Content:**
 ```python
 def clearArray():
 global array
 array.clear()
 ```- Clears all elements from the array.
--
### SLIDE 15: Merge Arrays
 **Title:** Merge Arrays
 **Content:**
 ```python
 def merge(*arrays):
 newArray = []
 for array in arrays:
 newArray.extend(array)
 print("Here is your merged array: ", newArray)
 ```- Merges multiple arrays into one.--
### SLIDE 16: Split Array
 **Title:** Split Array
 **Content:**
 ```python
 def splitArray(chunkSize):
 global array
 splittedArray = []
 for i in range(0, len(array), chunkSize):
 tempArr = [array[i], array[i+1]]
 splittedArray.append(tempArr)
 print("here is your splitted array: ", splittedArray)
 ```- Splits the array into chunks of a specified size.
 .
