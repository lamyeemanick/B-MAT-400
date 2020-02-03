/*
** EPITECH PROJECT, 2019
** 209poll_2018
** File description:
** Poll
*/

#include <unistd.h>
#include "Poll.hpp"
#include "SFML.hpp"
#include "OpenFile.hpp"
#include "Explode.hpp"

Poll::Poll()
{
    OpenFile file(".logs");
    _data = file.getData();

    std::vector<std::string> popu = Explode::explode(_data.at(0), '=');
    _population = std::stoi(popu.at(1));
    _population += 1;
    _data.at(0) = "population=";
    _data.at(0).append(std::to_string(_population));
    file.overwriteFile(_data);
}

Poll::~Poll()
{
    OpenFile file(".logs");
    file.overwriteFile(_data);
}

void Poll::openConcurrents(std::string const &data, std::string &file1, std::string &file2)
{
    std::vector<std::string>duel = Explode::explode(data, '=');
    std::vector<std::string>pair = Explode::explode(duel.at(0), ';');
    file1.assign(pair.at(0));
    file2.assign(pair.at(1));
}

void Poll::run()
{
    OpenFile file(".logs");
    SFML sfml;
    int pos = 1;
    int state = 0;
    std::string file1("");
    std::string file2("");

    while (sfml.isRunning()) {
        if (state == 0)
            state = sfml.drawStart();
        if (state == 1) {
            if (_data.at(pos).compare("END") == 0) {
                sleep(2);
                break;
            }
            openConcurrents(_data.at(pos), file1, file2);
            sfml.beforeStarting(file1, file2);
            state = 2;
            sleep(2);
        }
        if (state == 2)
            state = sfml.drawMain(_data.at(pos));
        if (state == 3) {
            sfml.drawPoll(_population, _data.at(pos));
            file.overwriteFile(_data);
            pos += 1;
            state = 1;
        }
        if (state == 4) {
            pos += 1;
            state = 1;
        }
        sfml.clear();
    }
}
