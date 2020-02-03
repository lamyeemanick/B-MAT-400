/*
** EPITECH PROJECT, 2019
** 209poll_2018
** File description:
** Calculs
*/

#include <cstdio>
#include <tgmath.h>
#include "Calculs.hpp"

Calculs::Calculs(int population, int pop, double percent)
{
    _percent = percent / 100;
    double fpc = ((double)population - (double)pop) / ((double)population - 1.0);
    double v = (_percent * (1 - _percent) * fpc) / pop;
    
    _f95 = _percent - (1.96 * sqrt(v));
    _f95 = (_f95 > 100) ? 100 : _f95;
    _f95 = (_f95 < 0) ? 0 : _f95;
    
    _s95 = _percent + (1.96 * sqrt(v));
    _s95 = (_s95 > 100) ? 100 : _s95;
    _s95 = (_s95 < 0) ? 0 : _s95;
    
    _f99 = _percent - (2.58 * sqrt(v));
    _f99 = (_f99 > 100) ? 100 : _f99;
    _f99 = (_f99 < 0) ? 0 : _f99;
    
    _s99 = _percent + (2.58 * sqrt(v));
    _s99 = (_s99 > 100) ? 100 : _s99;
    _s99 = (_s99 < 0) ? 0 : _s99;
 
    _percent *= 100;
}

Calculs::~Calculs()
{
}
