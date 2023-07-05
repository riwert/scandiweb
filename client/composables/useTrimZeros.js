export const useTrimZeros = (number) => {
  const floatNumber = parseFloat(number) // Make sure it is a number
  const roundedNumber = floatNumber.toFixed(2) // Round to 2 decimal places
  const decimalValue = roundedNumber.split('.')[1] // Extract the decimal value

  if (decimalValue === '00') {
    return roundedNumber.split('.')[0] // Return the integer part if decimal value is zero
  }

  if (roundedNumber.charAt(roundedNumber.length - 1) === '0') {
    return roundedNumber.slice(0, -1) // Remove the last character if it is '0'
  }

  return roundedNumber // Return the trimmed number
}
