set term pngcairo
set title "206Neutrinos"
set xlabel "Number of values"
set ylabel "Speed of particles"
set style data lines

set output 'image.png'

plot  'data' using 1:2:3 title "Standard deviation" w filledcurves closed lt rgb "0x99CCFF", \
      'data' using 1:4 title "Arithmetic" w lines lt rgb "red" lw 3, \
      'data' using 1:5 title "RMS" w lines lt rgb "blue", \
      'data' using 1:6 title "Harmonic" w lines lt rgb "0x33CC00"
